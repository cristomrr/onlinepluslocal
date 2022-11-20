<?php

/**
 * Clase encargada de la vista Header del sitio
 * @author Cristo Manuel Rodríguez Rodríguez
 * @version 1.0.0
 */
class Header
{
  /**
   * Almacena el código de la vista o componente de clase
   *
   * @var string código HTML de la vista o componente de clase
   */
  private string $code;
  private const LOGO = './assets/img/logo.png';
  private const ICON_HEADER =
  [
    'search' => ['href' => './?page=buscador', 'color' => 'white', 'title' => 'Buscador', 'text' => 'search'],
    'favorite' => ['href' => './?page=favoritos', 'color' => 'red', 'title' => 'Favoritos', 'text' => 'favorite'],
    'login' => ['href' => './?page=login', 'color' => 'white', 'title' => 'Login', 'text' => 'login'],
    'logout' => ['href' => './', 'color' => 'white', 'title' => 'Logout', 'text' => 'logout'],
    'seller' => ['href' => './?page=perfil-vendedor', 'color' => 'white', 'title' => 'Perfil', 'text' => 'store'],
    'buyer' => ['href' => './?page=perfil-cliente', 'color' => 'white', 'title' => 'Perfil', 'text' => 'person'],
  ];

  /**
   * Constructor del Header del sitio web
   *
   * @param string $logo Ruta a la imagen logo
   * @param array $linksHeader Enlaces con icono a crear con el orden de la posición del array.
   *              - Opciones disponibles:
   *                  favorite: Ruta a la vista de favoritos.
   *                  login: Ruta a la vista de Login.
   *                  logout: Ruta a la vista de Home.
   *                  seller: Ruta a la vista de Userdata de vendedores.
   *                  buyer: Ruta a la vista de Userdata de clientes.
   */
  public function __construct(array $linksHeader)
  {

    $this->code = '<header>
                    <div class="title-box">
                        <a href="/">
                            <img class="logo" src=' . self::LOGO . ' alt="Logo y enlace a la página principal" />
                        </a>
                        <h1>ONLINE plus LOCAL</h1>
                    </div>
                    ' . $this->getIconsHeader($linksHeader) . '
                    </header>';
  }

  /**
   * Crea los enlaces con icono para el Header
   *
   * @param array $iconsSelected Nombre de los enlaces a crear en el orden de la posición del array.
   * @return string Código HTML con el componente de iconos
   */
  private function getIconsHeader(array $iconsSelected)
  {
    $codeLinks = '';
    foreach ($iconsSelected as $selected) {

      $link = self::ICON_HEADER[$selected];

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

  /**
   * Código HTML del componente Header
   *
   * @return string Devuelve el código HTML con el Header del documento
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
