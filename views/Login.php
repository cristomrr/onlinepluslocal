<?php

/**
 * Clase con el contenido de la página Login y enlaces a las páginas de registro
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Login
{

  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;
  private const URL_PAGE_SIGNUP_BUYER = 'registro-cliente';
  private const URL_PAGE_SIGNUP_SELLER = 'registro-vendedor';
  private const INPUTS_FORM = [
    ["id" => "email", "label" => " Correo electrónico:", "type" => "email", "component" => "input"],
    ["id" => "password", "label" => " Contraseña:", "type" => "password", "component" => "input"],
  ];

  /**
   * Contiene el código HTML del contenido de la página Login
   *
   * @param string $urlServer Ruta al archivo del servidor al que se le enviará los formularios
   */
  public function __construct($urlServer)
  {
    $this->code =  '<section class="section-login">
              <div class="form-login">
              ' . $this->getForm($urlServer) . '
              </div>

              <p>¿No tienes una cuenta?</p>

              <div class="login-btn">
                <a href="/?page=' . self::URL_PAGE_SIGNUP_BUYER . '">Crear cuenta de cliente</a>
                <p>ó</p>
                <a href="/?page=' . self::URL_PAGE_SIGNUP_SELLER . '">Crear cuenta de empresa</a>
              </div>
            </section>';
  }

  /**
   * Crea el formulario de login
   *
   * @return string Código HTML con el formulario para ser agregado al documento
   */
  private function getForm($urlServer): string
  {
    $form = new Form(
      [
        'name' => 'login',
        'legend' => 'Iniciar sesión',
        'url' => $urlServer,
        'method' => 'POST',
        'fieldset' => true
      ],
      self::INPUTS_FORM,
      [
        'text' => 'Enviar',
        'icon' => 'chevron_right'
      ],
      ''
    );

    return $form->getCode();
  }


  /**
   * Código HTML de la vista Login
   *
   * @return string Devuelve el código HTML con el componente Login
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
