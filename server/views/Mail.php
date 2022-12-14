<?php

class Mail
{
  /**
   * Email enviado para dar la bienvenida al usuario y confirmar que está registrado
   *
   * @param array $user nombre del usuario a ver en el mensaje
   * @return string código HTML del mensaje
   */
  public static function getConfirmationHTML(array $user): string
  {
    return "<!DOCTYPE html>
    <html lang='es'>
    
      <head>
        <meta charset='UTF-8'>
        <link href='https://fonts.googleapis.com'
              rel='preconnect'>
        <link crossorigin
              href='https://fonts.gstatic.com'
              rel='preconnect'>
        <link href='https://fonts.googleapis.com/css2?family=Candal&display=swap'
              rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css2?family=Montserrat&display=swap'
              rel='stylesheet'>
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
    
      <body style='width: 100%; height: 100%;'>
        <div style='width: 51rem; margin-top: 1rem;'>
    
          <main>
    
            <h4 style='font-size: 1.4rem;'>¡Hola $user[username]!</h4>
            <br>
    
            <p>
              <span style='color: #104167;font-weight: bold;'>¡Bienvenid@ a OnlinePlusLocal!</span>
            </p>
            <br>
    
            <p>Estamos muy agradecidos de que hayas decidido probar nuestra plataforma para buscar productos
              de forma diferente a lo que se hace hoy en día, ¡ahora podrás encontrar cosas cerca de casa!.</p>
            <br>
    
            <p style='color: #104167;font-weight: bold;'>Cualquier sugerencia es bienvenida en onlinepluslocal@cmrr.es.
            </p>
            <br>
          </main>
        </div>
      </body>
    
    </html>";
  }
}
