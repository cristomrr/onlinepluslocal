<?php

/**
 * Clase con el contenido de la página Login y enlaces a las páginas de registro
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Login extends ViewComponent
{
  private const INPUTS_FORM = [
    ["id" => "email", "label" => " Correo electrónico:", "type" => "email", "component" => "input"],
    ["id" => "password", "label" => " Contraseña:", "type" => "password", "component" => "input"],
  ];

  /**
   * Contiene el código HTML del contenido de la página Login
   *
   * @param array $urlServer Ruta al archivo del servidor al que se le enviará los formularios
   */
  public function __construct(array $url)
  {
    $code =  '<section class="section-login">
              <div class="form-login">
              ' . $this->getForm($url['server']) . '
              </div>

              <p>¿No tienes una cuenta?</p>

              <div class="login-btn">
                <a href="'.$url['server'].'/?page=' . $url['signup-buyer'] . '">Crear cuenta de cliente</a>
                <p>ó</p>
                <a href="'.$url['server'].'/?page=' . $url['signup-seller'] . '">Crear cuenta de empresa</a>
              </div>
            </section>';

            parent::__construct($code);
  }

  /**
   * Crea el formulario de login
   *
   * @return string Código HTML con el formulario de login
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
}
