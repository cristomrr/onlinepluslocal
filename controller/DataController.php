<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//$URL_SERVER = 'https://historiatelo.com/timeline/';



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
  public function login(string $email, string $passw)
  {
    $user = (isset($email) ? htmlentities(addslashes($email)) : null);
    $password = (isset($passw) ? htmlentities(addslashes($passw)) : null);

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


  public function searchArticle($filters)
  {
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

  public function getFavorites()
  {
    
  }




  /**
   * Acción al regisrarse nuevo usuario
   */
  public function signup()
  {
    // if ($input->action === "signup") {
    //   $user = (isset($input->username) ? htmlentities(addslashes($input->username)) : null);
    //   $passw = (isset($input->password) ? htmlentities(addslashes($input->password)) : null);
    //   $email = (isset($input->email) ? htmlentities(addslashes($input->email)) : null);

    //   if ($user && $passw && $email) {
    //       $resp = $timeline->checkUserExist($user, $email);

    //       if (!$resp['user']['username'] && !$resp['user']['email']) {
    //           $resp['ok'] = $timeline->createUser($user, $passw, $email);
    //           $idUser = $timeline->getLastId('users');

    //           if ($resp['ok']) {
  }

  public function sendMailConfirmation()
  {

    try {
      require_once './Confirmation.php';
      $lastIdUser = $timeline->getLastId('users');
      $messageHTML = Confirmation::getConfirmationHTML($lastIdUser);

      $mail = new PHPMailer(true);
      $mail->SMTPDebug = SMTP::DEBUG_OFF;   //Muestra las trazas del mail, 0 para ocultarla
      $mail->Host = "smtp.ionos.es";
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Username = "onlinepluslocal@cmrr.es";
      $mail->Password = "#Ev@#646879663#Mash@#";
      $mail->Port = 587;
      $mail->CharSet = 'UTF-8';

      $mail->setFrom("onlinepluslocal@cmrr.es", "OnlinePlusLocal");
      $mail->addAddress($email, $user);

      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Verifica tu email';
      $mail->MsgHTML($messageHTML);
      $mail->AltBody = "Para activar tu cuenta en OnlinePlusLocal copia el siguiente enlace 
                    y pegalo en el navegador:  
                    https://onlinepluslocal.cmrr.es/?action=activate,?user=$iduser";
      $mail->send();
      $resp['ok'] = true;
      $resp['message'] = ['¡OK!', 'Consulta tu correo electrónico', 'para verificar el registro'];
    } catch (Exception $err) {
      $resp['ok'] = false;
      $resp['message'] = ["Error con el servicio de correo.", " Info: {$mail->ErrorInfo}"];
    }
  }
}
