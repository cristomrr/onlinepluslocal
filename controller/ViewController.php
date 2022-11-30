<?php
session_start();

/**
 * Clase encargada del manejo de las vistas del sitio web
 */
class ViewController
{

  private const URL = [
    'server' => '',
    'signup-seller' => 'registro-empresa',
    'signup-buyer' => 'registro-cliente',
    'contact' => 'contacto',
    'privacy' => '',
  ];
  private const LINKS = [
    'search' => ['href' => './?page=buscador', 'color' => 'white', 'title' => 'Buscador', 'text' => 'search'],
    'favorite' => ['href' => './?page=favoritos', 'color' => 'red', 'title' => 'Favoritos', 'text' => 'favorite'],
    'login' => ['href' => './?page=login', 'color' => 'white', 'title' => 'Login', 'text' => 'login'],
    'logout' => ['href' => './?action=logout', 'color' => 'white', 'title' => 'Logout', 'text' => 'logout'],
    'user' => ['href' => './?page=perfil', 'color' => 'white', 'title' => 'Perfil', 'text' => 'person'],
  ];

  private const PAGES_NEED_SESSION = ['perfil', 'favoritos', 'buscador', 'resultado-busqueda'];

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
  public function printView(string $page, array $articles = [], $options = []): void
  {
    $page = (isset($_SESSION['user']))
      ? $page
      : (!in_array($page, self::PAGES_NEED_SESSION)
        ? $page
        : 'login');

    match ($page) {
      'perfil' => $this->setPage(new Userdata(self::URL, $this->db->getUser($_SESSION['user'])), true),
      'favoritos' => $this->setPage(new Favorite(self::URL, $this->db->getUserFavorites(intval($_SESSION['user']))), true),
      'buscador' => $this->setPage(new Search(self::URL, $this->db->getAllArticles()), true),
      'resultado-busqueda' => $this->setPage(new Search(self::URL, $articles), true),
      'registro-cliente' => $this->setPage(new Signup(self::URL, 'buyer'), false),
      'registro-empresa' => $this->setPage(new Signup(self::URL, 'seller'), false),
      'contacto' => $this->setPage(new Contact(self::URL), false),
      'login', 'out-session' => $this->setPage(new Login(self::URL), false),
      default => $this->setPage(new Home(self::URL), false),
    };
  }

  /**
   * Crea e imprime en el navegador la página agregando las vistas pasadas por parámetro al documento
   *
   * @param ViewComponent $content Contenido de la página (Main)
   */
  private function setPage(ViewComponent $content, bool $needSession): void
  {
    $head = new Head(self::URL);

    $linksHeader = (isset($_SESSION['user']))
      ? array_filter(self::LINKS, fn ($k) => $k !== 'login', ARRAY_FILTER_USE_KEY)
      : [self::LINKS['login']];
    $header = new Header($linksHeader, self::URL);

    $content = ($needSession)
      ? (isset($_SESSION['user']) ? $content : new Login(self::URL))
      : $content;

    $footer = new Footer(self::URL);

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
