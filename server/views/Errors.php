<?php

class Errors extends ViewComponent
{

  /**
   * Construye el contenido de la página de error dependiendo del tipo de error generado.
   * 
   * @param string $type el tipo de error. Disponibles: login, mail, server
   */
  public function __construct(string $type)
  {
    $info = match ($type) {
      'login' => $this->login(),
      'mail' => $this->mail(),
      'server' => $this->server(),
    };

    $code = '<div class="content-error">
              <section class="error-img">
              <h1 class=error-title>' . $info["title"] . '</h1>
                <picture>
                  <img src="' . $info["img"] . '" alt="aviso de error">
                </picture>
              </section>

              <section class="error-msg">
                <p>' . $info["msg"] . '</p>
                <input class="button-back" type="button" value="Volver" onClick="history.go(-1);">
                </section>';

    parent::__construct($code);
  }


  /**
   * Configuración de error cuando los datos del login incorrectos 
   *
   * @return array 
   */
  public function login(): array
  {
    return
      [
        'title' => 'Datos incorrectos',
        'img' => 'server/assets/img/login-error.jpg',
        'msg' => 'El correo electrónico y/o contraseña son incorrectos, si el problema persiste ponte en contacto con nosotros e intentaremos solucionarlo'
      ];
  }

  /**
   * Configuración de error cuando no se puede enviar un email 
   * 
   * @return array
   */
  public function mail(): array
  {
    return
      [
        'title' => 'Error de envío.',
        'img' => 'server/assets/img/mail-error.jpg',
        'msg' => 'Error al enviar el email, si el problema persiste ponte en contacto con nosotros e intentaremos solucionarlo.'
      ];
  }


  /**
   * Configuración del error cuando hay un problema de gestión en el servidor (mover archivo, cargar imagen,...)
   * 
   * @return array
   */
  public function server(): array
  {
    return
      [
        'title' => 'Error en el servidor',
        'img' => 'server/assets/img/server-error.jpg',
        'msg' => 'Error en el servidor al realizar la acción, si el problema persiste ponte en contacto con nosotros e intentaremos solucionarlo.'
      ];
  }
}
