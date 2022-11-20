<?php

/**
 * Clase encargada de la vista Footer del sitio
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Footer
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;
  public const URL_CONTACT = 'contacto';
  public const URL_PRIVACY = './';



  /**
   * Constructor para la creación del componente Footer
   *
   * @param string $urlContact Ruta a a la página de contacto
   * @param string $urlPrivacy Ruta a a la página información sobre la privacidad de datos
   */
  public function __construct()
  {
    $this->code = '<footer>
                    <div class="link">
                      <a href="/?page=' . self::URL_CONTACT . '">Contacto</a>
                      <a href="' . self::URL_PRIVACY . '">Privacidad</a>
                      <a href="' . './ ' . '">Cookies</a>
                    </div>
                    <p>Todos los derechos reservados © OnlinePlusLocal</p>
                  </footer>';
  }

  /**
   * Código HTML del componente Footer
   *
   * @return string Devuelve el código HTML con el Footer del documento
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
