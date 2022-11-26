<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once './vendor/autoload.php';

try {
    require_once './Confirmation.php';
    $lastIdUser = $timeline->getLastId('users');
    $messageHTML = Confirmation::getConfirmationHTML($lastIdUser);

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_OFF;   //Muestra las trazas del mail, 0 para ocultarla
    $mail->Host = "mail.historiatelo.com";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Username = "info@historiatelo.com";
    $mail->Password = "4LiamAs#2@";
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom("info@historiatelo.com", "Historiatelo.com");
    $mail->addAddress($email, $user);

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verifica tu email';
    $mail->MsgHTML($messageHTML);
    $mail->AltBody = "Para activar tu cuenta en Historiatelo.com copia el siguiente enlace 
                    y pegalo en el navegador:  
                    https://historiatelo.com/timeline/loginserver.php?activate=$idUser";
    $mail->send();
    $resp['ok'] = true;
    $resp['message'] = ['¡OK!', 'Consulta tu correo electrónico', 'para verificar el registro'];
} catch (Exception $err) {
    $resp['ok'] = false;
    $resp['message'] = ["Error con el servicio de correo.", " Info: {$mail->ErrorInfo}"];
}