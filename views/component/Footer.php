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
                      <a href="/?page=' . $url['contact'] . '">Contacto</a>
                      <a href="' . $url['privacy'] . '">Privacidad</a>
                      <a href="' . './ ' . '">Cookies</a>
                    </div>
                    <p>Todos los derechos reservados © OnlinePlusLocal</p>
                  </footer>';

    parent::__construct($code);
  }
}
