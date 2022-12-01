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

  private $db;

  public function __construct()
  {
    $this->db = new DBAction();
  }


  /**
   * Imprime la vista solicitada dependiendo del parámetro
   *
   * @param string $page Indica que vista cargar
   * @return void
   */
  public function printView(string $page, array $content = []): void
  {
    $page = (isset($_SESSION['user']))
      ? $page
      : (!in_array($page, ENV::PAGES_NEED_SESSION)
        ? $page
        : 'login');

    match ($page) {
      'data-user' => $this->setPage(new Userdata($this->db->getUser($_SESSION['user'])), true),
      'favorites' => $this->setPage(new Favorite($content), true),
      'search' => $this->setPage(new Search($content), true),
      'result-search' => $this->setPage(new Search($content), true),
      'signup' => $this->setPage(new Signup($content['user']), false),
      'contact' => $this->setPage(new Contact(), false),
      'login', 'out-session' => $this->setPage(new Login(), false),
      'error' => $this->setPage(new Errors(ERROR_CODE::setError(ERROR_CODE::CONNECT_DB)), false),
      default => $this->setPage(new Home(), false),
    };
  }

  /**
   * Crea e imprime en el navegador la página agregando las vistas pasadas por parámetro al documento
   *
   * @param ViewComponent $content Contenido de la página (Main)
   */
  private function setPage(ViewComponent $content, bool $needSession): void
  {
    $head = new Head();

    $linksHeader = (isset($_SESSION['user']))
      ? array_filter(self::LINKS, fn ($k) => $k !== 'login', ARRAY_FILTER_USE_KEY)
      : [self::LINKS['login']];
    $header = new Header($linksHeader);

    $content = ($needSession)
      ? (isset($_SESSION['user']) ? $content : new Login())
      : $content;

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
