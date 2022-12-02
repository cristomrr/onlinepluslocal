<?php

/**
 * Clase encargada de la vista Header del sitio
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Header extends ViewComponent
{
  /**
   * Constructor del Header del sitio web
   *
   * @param array $linksHeader Enlaces con icono a crear con el orden de la posición del array.
   */
  public function __construct(array $linksHeader)
  {
    $code = '<header>
                    <div class="title-box">
                        <a href="' . ENV::serverURL() . '">
                            <img class="logo" src=' . ENV::LOGO . ' alt="Logo y enlace a la página principal" />
                        </a>
                        <h1>ONLINE plus LOCAL</h1>
                    </div>
                    ' . $this->getIconsHeader($linksHeader) . '
                    </header>';

    parent::__construct($code);
  }

  /**
   * Crea los enlaces con icono para el Header
   *
   * @param array $linksHeader Nombre de los enlaces a crear en el orden de la posición del array.
   * @return string Código HTML con el componente de iconos
   */
  private function getIconsHeader(array $linksHeader)
  {
    $codeLinks = '';
    foreach ($linksHeader as $link) {

      $codeLinks .= '<a class="box-button" href=' . $link['href'] . ' target=_self>
                      <span class="material-symbols-outlined ' . $link['color'] . '" title=' . $link['title'] . '>
                        ' . $link['text'] . '
                      </span>
                      <p class="white hidden">
                        ' . $link['title'] . '
                      </p>
                    </a>';
    }

    return '<div class="icon-box">' . $codeLinks . '</div>';
  }
}
