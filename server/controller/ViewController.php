<?php
session_start();

/**
 * Clase encargada del manejo de las vistas del sitio web
 */
class ViewController
{
  private const LINKS = [
    'search' => ['href' => '/buscador', 'color' => 'white', 'title' => 'Buscador', 'text' => 'search'],
    'favorite' => ['href' => '/favoritos', 'color' => 'red', 'title' => 'Favoritos', 'text' => 'favorite'],
    'login' => ['href' => '/iniciar-sesion', 'color' => 'white', 'title' => 'Login', 'text' => 'login'],
    'logout' => ['href' => './?action=logout', 'color' => 'white', 'title' => 'Logout', 'text' => 'logout'],
    'user' => ['href' => '/perfil', 'color' => 'white', 'title' => 'Perfil', 'text' => 'person'],
  ];

  public function __construct()
  {
  }


  /**
   * Imprime la vista solicitada dependiendo del parámetro
   *
   * @param string $page Indica que vista cargar, en caso de no existir cargará la de inicio
   * @param array $content Datos de contenido para cada vista, pudiendo ser artículos o datos del usuario entre otros
   * @return void
   */
  public function printView(string $page, array $content = []): void
  {
    match ($page) {
      'userdata' => $this->setPage(new Userdata($content)),
      'favorites' => $this->setPage(new Favorite($content)),
      'search' => $this->setPage(new Search($content)),
      'result-search' => $this->setPage(new Search($content)),
      'signup' => $this->setPage(new Signup($content['user'])),
      'contact' => $this->setPage(new Contact()),
      'login', 'out-session' => $this->setPage(new Login()),
      'error' => $this->setPage(new Errors(ERROR_CODE::setError($content['code']))),
      default => $this->setPage(new Home()),
    };
  }

  /**
   * Crea e imprime en el navegador la página agregando las vistas pasadas por parámetro al documento
   *
   * @param ViewComponent $content Contenido de la página (Main)
   */
  private function setPage(ViewComponent $content): void
  {
    $head = new Head();

    $linksHeader = (isset($_SESSION['user']))
      ? array_filter(self::LINKS, fn ($k) => $k !== 'login', ARRAY_FILTER_USE_KEY)
      : [self::LINKS['login']];
    $header = new Header($linksHeader);

    // $content = ($needSession)
    //   ? (isset($_SESSION['user']) ? $content : new Login())
    //   : $content;

    $footer = new Footer();

    $doc = '<!DOCTYPE html>
            <html lang="es">
              ' . $head->getCode() . '
              <body>
                ' . $header->getCode() . '
                <main class="content-body">
                  ' . $content->getCode() . '
                </main>
                ' . $footer->getCode() . '
              </body>
            </html>';

    echo $doc;
  }
}
