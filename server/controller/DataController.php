<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


/**
 * Clase encargada de la manipulación de datos en el servidor, como login, registro, subida de archivos u obtención de datos
 */
class DataController
{

  /**
   * Almacena la conexión a la base de datos
   * @var mixed
   */
  private $db;

  /**
   * Prepara la clase obteniendo la conexión a la base de datos
   */
  public function __construct()
  {
    $this->db = new DBAction();
  }


  /**
   * Acción al iniciar sesión un usuario registrado
   */
  public function login(): void
  {
    $user = (isset($_POST['email']) ? htmlentities(addslashes($_POST['email'])) : null);
    $password = (isset($_POST['password']) ? htmlentities(addslashes($_POST['password'])) : null);

    if ($user && $password) {
      $dbResp = $this->db->checkUserLogin($user, $password);
      if ($dbResp) {
        $_SESSION['user'] = $dbResp['id'];
        header('location: ' . ENV::serverURL() . ENV::ROUTE['search']);
      } else {
        echo 'Usuario o contraseña incorrectos';
      }
    }
  }

  /**
   * Acción al cerrar sesión un usuario registrado
   *
   * @return void
   */
  public function logout(): void
  {
    unset($_SESSION['user']);
    header('location: ' . ENV::serverURL());
  }


  /**
   * Acción al modificar los datos de usuario en el formulario del perfil
   *
   * @return void
   */
  public function updateUserdata(): void
  {
    $resp = $this->db->updateUser(
      [
        'id' => $_SESSION['user'],
        'name' => $_POST['name'],
        'document' => $_POST['document'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'province' => $_POST['province'],
      ]
    );
  }


  /**
   * Acción al registrarse nuevo usuario
   * 
   * @return void
   */
  public function signup(): void
  {
    $user = [
      'type' => ($_POST['action'] === 'signup-seller') ? 'seller' : 'buyer',
      'name' => htmlentities(addslashes($_POST['name'])),
      'document' => htmlentities(addslashes($_POST['document'])),
      'phone' => htmlentities(addslashes($_POST['phone'])),
      'email' => htmlentities(addslashes($_POST['email'])),
      'address' => htmlentities(addslashes($_POST['address'])),
      'city' => htmlentities(addslashes($_POST['city'])),
      'province' => htmlentities(addslashes($_POST['province'])),
      'password' => htmlentities(addslashes($_POST['password']))
    ];

    if ($this->db->checkUserEmailExist($user['email'])) {
      echo 'Respuesta del servidor: Ya existe un usuario con ese email';
    } else {
      if ($this->db->setUser($user)) {
        // require_once './views/Mail.php';
        $lastUser = $this->db->getUser('LAST_INSERT_ID()');
        $messageHTML = Mail::getConfirmationHTML($lastUser);
        $altMsg = "¡Hola $lastUser[username]. Bienvenid@ a OnlinePlusLocal. 
        Estamos muy agradecidos de que hayas decidido probar nuestra plataforma para buscar productos de forma diferente a lo que se hace hoy en día, ¡ahora podrás encontrar cosas cerca de casa!.
        Cualquier sugerencia es bienvenida en onlinepluslocal@cmrr.es.";

        $this->sendMail($messageHTML, $altMsg, $lastUser['username'], $lastUser['email'], 'Mensaje de bienvenida');
        header('location: ' . ENV::serverURL() . ENV::ROUTE['login']);
      }
    }
  }


  /**
   * Envía mensaje el formulario de contacto al correo electrónico especificado
   *
   * @return void
   */
  public function contact()
  {
    $doc = '<!DOCTYPE html>
            <html lang="es">
              <body>
                <main class="content-body">
                  <h1>' . $_POST['subject'] . '</h1>
                  <p>' . $_POST['msg'] . '</p>
                  <br>
                  <p>' . $_POST['email'] . '</p>
                </main>
              </body>
            </html>';

    $altMsg = "Contacto $_POST[email]:  $_POST[msg]";
    $this->sendMail($doc, $altMsg, 'Contacto', 'onlinepluslocal@cmrr.es', 'Mensaje de Contacto');
    header('location: ' . ENV::serverURL() . ENV::ROUTE['contact']);
  }

  /**
   * Envia un email según los parámetros de entrada
   *
   * @param string $messageHTML Código HTML para ser enviado como mensaje de email
   * @param string $altMsg Texto alternativo si el cliente de correo no puede mostrar HTML
   * @param string $sendUser Nombre de usuario al que se envía el email
   * @param string $sendEmail Dirección de email al que enviar
   * @return void
   */
  public function sendMail(string $messageHTML, string $altMsg, string $sendUser, string $sendEmail, string $subject): void
  {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;   //Muestra las trazas del mail, 0 para ocultarla en producción

    $mail->IsSMTP();
    $mail->Host = "smtp.ionos.es";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Username = ENV::EMAIL_ACCOUNT;
    $mail->Password = ENV::EMAIL_PASSWORD;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("onlinepluslocal@cmrr.es", "OnlinePlusLocal");
    $mail->addAddress($sendEmail, $sendUser);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $subject;
    $mail->MsgHTML($messageHTML);
    $mail->AltBody = $altMsg;

    try {
      $mail->send();
    } catch (Exception $err) {
      echo "Error al enviar el email. Info: {$mail->ErrorInfo}";
    }
  }


  /**
   * Solicita al modelo los artículos filtrando los resultados según las opciones del usuario en el formulario
   *
   * @return array Colección de registros que coinciden con los filtros recibidos
   */
  public function searchArticle(ViewController $vc): array
  {
    $filters = [
      'name' => $_POST['name'],
      'province' => $_POST['province'],
      'city' => $_POST['city']
    ];
    $sqlFilterWhere = 'WHERE';
    $isFirst = true;
    foreach ($filters as $column => $value) {
      $sqlFilterWhere .= (!$isFirst && $value !== '') ? ' OR ' : '';
      $sqlFilterWhere .= ($value !== '') ?  " $column LIKE '%$value%'" : '';
    }

    $sqlFilterWhere = ($sqlFilterWhere === 'WHERE') ? '' : $sqlFilterWhere;

    $resp = $this->db->getArticle($sqlFilterWhere);
    $vc->printView('result-search', $resp);

    return $resp;
  }


  public function getArticles(string $filter): array
  {
    $articles = match ($filter) {
      'all' => $this->db->getAllArticles(),
      'favorites' => $this->db->getUserFavorites(intval($_SESSION['user'])),
    };

    return $articles;
  }


  /**
   * Método encargado de almacenar la imagen recibida en el formulario de nuevo artículo con los datos correspondientes
   *
   * @return void
   */
  public function uploadArticle(): void
  {
    try {

      if (isset($_FILES['upfile'])) {
        $idArticle = ($this->db->getLastIDArticle() + 1);
        $extension =  pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION);
        $path = "/assets/users/$_SESSION[user]/$idArticle.$extension";
        if (move_uploaded_file($_FILES['upfile']['tmp_name'], $path)) {
          $resp = $this->db->setArticle(
            [
              'id' => $idArticle,
              'name' => $_POST['name'],
              'img' => $path,
              'description' => $_POST['description'],
              'price' => $_POST['price'] . '$',
              'iduser' => $_SESSION['user']
            ]
          );
        } else {
          echo 'no se ha podido mover la imagen a la carpeta';
        }
      }
    } catch (Exception $e) {
      echo 'error al almacenar la imagen del artículo';
    }
  }


  /**
   * Agrega o elimina artículos favoritos al usuario que ha iniciado sesión 
   *
   * @return void
   */
  public function changeFavorites(): void
  {
    if ($_POST['like'] === 'true') {
      $this->db->setUserFavorites(intval($_SESSION['user']), intval($_POST['id']));
    } else {
      $this->db->deleteUserFavorites(intval($_SESSION['user']), intval($_POST['id']));
    }
  }

  public function needSession(): array
  {
    if (isset($_SESSION['user'])) {
      return $this->db->getUser($_SESSION['user']);
    } else {
      header('location:' . ENV::serverURL() . ENV::ROUTE['login']);
      die();
    }
  }
}
