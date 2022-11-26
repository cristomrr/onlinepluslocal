<?php

class Confirmation
{
    public static function getConfirmationHTML($idUser)
    {
        return "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <link href='https://fonts.googleapis.com' rel='preconnect'>
    <link crossorigin href='https://fonts.gstatic.com' rel='preconnect'>
    <link href='https://fonts.googleapis.com/css2?family=Candal&display=swap' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css2?family=Montserrat&display=swap' rel='stylesheet'>
    <title>Página de activación de cuenta</title>
    <style>
        * {
    box-sizing: border-box;
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body style='width: 100%;
             height: 100%;'>
<!--    contenedor      -->
<div style='width: 51rem;
            margin-top: 1rem;'>

    <!--    header      -->
    <header style='height:190px;background-color: #01B4AE;border-top-right-radius: 22px;border-top-left-radius: 22px'>
        <img
                alt='Historiatelo, gracias por registrarte'
                height='190px'
                src='https://historiatelo.com/timeline/asset/header-confirmation.png'
                style='object-fit: none; object-position: 0px 0px; margin: 0 120px;'
                width='520px'
                    >
    </header>

    <a href='https://historiatelo.com/timeline/loginserver.php?activate=$idUser'
       style='background-color: #b32786;
                          border: none;
                          color: #fff;
                          font-size: 0.8rem;
                          font-weight: 500;
                          padding: 0.8rem 1.5rem;
                          border-radius: 0.5rem;
                          text-decoration: none;
                          height: 2.5rem;
                          width: 10.4rem;
                          margin: 1rem;
                          display: block;
                          margin: 1rem auto;
                '
       target='_blank'>VERIFICAR EMAIL
</a>

    <main>

        <h4 style='font-size: 1.4rem;'>¡Hola " . self::getUsername($idUser) . "!</h4>
        <br>

        <p>Eres una de las primeras personas en registrarte en Historiatelo.com. y, por tanto eres nuestr@
            <span style='color: #b32786;font-weight: bold;'>BETA TESTER</span></p>
        <br>

        <p>Estamos muy agradecidos de tu participación en el proceso de testeo y nos gustaría que nos des tu feedback
            sobre
            la experiencia de navegación en la web, en el editor y en el visor de las historias.</p>
        <br>

        <p style='color: #b32786;font-weight: bold;'>Te invitamos a que crees tantas HISTORIAS como creas
            conveniente.</p>
        <br>

        <p>Ponemos a tu disposición nuestro correo
<span style='color: #b32786;font-weight: bold;'>info@historiatelo.com</span> para cuantas
            alegaciones, consejos, exigencias e ideas estimes oportunas compartir con nosotros para mejorar esta
            nueva plataforma que aspira a ser la próxima enciclopedia interactiva.</p>
        <br>
    </main>
</div>
</body>
</html>";

    }

    private static function getUsername($idUser)
    {
        try {

            //            include_once './Timeline.php';
            global $timeline;
            //            $timeline = new Timeline();
            if (!$timeline->db) {
                throw new Exception('conexión a la base de datos');
            }

            $userdata = $timeline->readUserData($idUser);
            if (isset($userdata)) {
                return $userdata['username'];
            } else {
                throw new Exception('obtener el nombre de usuario');
            }

        } catch (Exception $e) {
            return false;
        }
    }
}