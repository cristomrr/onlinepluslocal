<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class DataController
{

  private $db;
  private $vc;

  public function __construct()
  {
    require_once './vendor/autoload.php';
    require_once './model/DBAction.php';

    $this->db = new DBAction();
    $this->vc = new ViewController();
  }


  /**
   * Acción al iniciar sesión un usuario registrado
   */
  public function login()
  {
    $user = (isset($_POST['email']) ? htmlentities(addslashes($_POST['email'])) : null);
    $password = (isset($_POST['password']) ? htmlentities(addslashes($_POST['password'])) : null);

    // TODO: agregar comprobar cuenta activa

    if ($user && $password) {
      $dbResp = $this->db->checkUserLogin($user, $password);
      if ($dbResp) {
        $_SESSION['user'] = $dbResp['id'];
        $this->vc->printView('buscador');
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
  public function logout()
  {
    unset($_SESSION['user']);
    $this->vc->printView('home');
  }


  public function updateUserdata()
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
   */
  public function signup()
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
        require_once './views/Mail.php';
        $lastUser = $this->db->getUser('LAST_INSERT_ID()');
        $messageHTML = Mail::getConfirmationHTML($lastUser);
        $altMsg = "¡Hola $lastUser[username]. Bienvenid@ a OnlinePlusLocal. 
        Estamos muy agradecidos de que hayas decidido probar nuestra plataforma para buscar productos de forma diferente a lo que se hace hoy en día, ¡ahora podrás encontrar cosas cerca de casa!.
        Cualquier sugerencia es bienvenida en onlinepluslocal@cmrr.es.";

        $this->sendMail($messageHTML, $altMsg, $lastUser['username'], $lastUser['email']);
        $this->vc->printView('login');
      }
    }
  }

  public function sendMail($messageHTML, $altMsg, $sendUser, $sendEmail)
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
    $mail->Subject = 'Mensaje de bienvenida';
    $mail->MsgHTML($messageHTML);
    $mail->AltBody = $altMsg;

    try {
      $mail->send();
    } catch (Exception $err) {
      echo "Error al enviar el email. Info: {$mail->ErrorInfo}";
    }
  }


  public function searchArticle()
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
    $this->vc->printView('resultado-busqueda', $resp);

    return $resp;
  }


  public function uploadArticle()
  {
    if (isset($_FILES['upfile'])) {
      $idArticle = ($this->db->getLastIDArticle() + 1);
      $extension =  pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION);
      $path = "./assets/users/$_SESSION[user]/$idArticle.$extension";
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
        echo 'Respuesta de la DB base de datos: ' . $resp;
      } else {
        echo 'no movido a carpeta';
      }
    }
  }


  public function changeFavorites()
  {
    if ($_POST['like'] === 'true') {
      $this->db->setUserFavorites(intval($_SESSION['user']), intval($_POST['id']));
    } else {
      $this->db->deleteUserFavorites(intval($_SESSION['user']), intval($_POST['id']));
    }
  }
}
