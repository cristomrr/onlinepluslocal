<?php

/**
 * Clase encargada de la vista Footer del sitio
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Footer extends ViewComponent
{
  /**
   * Constructor para la creación del componente Footer
   * 
   *@param array $url Rutas de enlace, como al archivo principal del servidor para formularios
   */
  public function __construct(array $url)
  {
    $code = '<footer>
                    <div class="link">
                      <a href="'.$url['server'].'/?page=' . $url['contact'] . '">Contacto</a>
                      <a href="' . 'javascript:;' . '">Privacidad</a>
                      <a href="' . 'javascript:;' . '">Cookies</a>
                    </div>
                    <p>Todos los derechos reservados © OnlinePlusLocal 2022</p>
                  </footer>';

    parent::__construct($code);
  }
}
