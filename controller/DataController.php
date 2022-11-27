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
   * Acción al activar la cuenta mediante el enlace de email
   */
  public function activateCount()
  {
  }

  /**
   * Acción al iniciar sesión un usuario registrado
   */
  public function login()
  {
    $user = (isset($email) ? htmlentities(addslashes($_POST['email'])) : null);
    $password = (isset($passw) ? htmlentities(addslashes($_POST['password'])) : null);

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


  /**
   * Acción al regisrarse nuevo usuario
   */
  public function signup()
  {
    $user = [
      'type' => ($_POST['formname'] === 'signup-seller') ? 'seller' : 'buyer',
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
        $altMsg = "Para activar tu cuenta en OnlinePlusLocal copia el siguiente enlace y pegalo en el navegador:  
        https://onlinepluslocal.cmrr.es/?action=activate,?.user=" . $LastUser['id'];

        echo $messageHTML;
        exit;

        $this->sendMail($messageHTML, $altMsg, $lastUser['username'], $lastUser['email']);
        $this->vc->printView('login');
      }
    }
  }

  public function sendMail($messageHTML, $altMsg, $sendUser, $sendEmail)
  {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 3;   //Muestra las trazas del mail, 0 para ocultarla en producción

    $mail->IsSMTP();
    $mail->Host = "smtp.ionos.es";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Username = "onlinepluslocal@cmrr.es";
    $mail->Password = ""; //TODO: aquí poner la contraseña del servidor
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("onlinepluslocal@cmrr.es", "OnlinePlusLocal");
    $mail->addAddress($sendEmail, $sendUser);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Verifica tu email';
    $mail->MsgHTML($messageHTML);
    $mail->AltBody = $altMsg;

    try {
      $mail->send();
      echo 'Activa tu cuenta en el mensaje enviado a tu email y podrás iniciar sesión';
    } catch (Exception $err) {
      echo "Error al enviar el email. Info: {$mail->ErrorInfo}";
    }
  }
}
