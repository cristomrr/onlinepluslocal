<?php
session_start();

class ViewController
{

  private const URL = [
    'server' => './index.php',
    'signup-seller' => 'registro-empresa',
    'signup-buyer' => 'registro-cliente',
    'contact' => 'contacto',
    'privacy' => '#',
  ];
  private const LINKS =
  [
    'search' => ['href' => './?page=buscador', 'color' => 'white', 'title' => 'Buscador', 'text' => 'search'],
    'favorite' => ['href' => './?page=favoritos', 'color' => 'red', 'title' => 'Favoritos', 'text' => 'favorite'],
    'login' => ['href' => './?page=login', 'color' => 'white', 'title' => 'Login', 'text' => 'login'],
    'logout' => ['href' => './?action=logout', 'color' => 'white', 'title' => 'Logout', 'text' => 'logout'],
    'user' => ['href' => './?page=perfil', 'color' => 'white', 'title' => 'Perfil', 'text' => 'person'],
  ];
  // private $dc;
  private $db;

  public function __construct()
  {
    require_once './views/ViewComponent.php';

    require_once './views/component/Head.php';
    require_once './views/component/Header.php';
    require_once './views/component/Footer.php';

    require_once './views/Home.php';
    require_once './views/Contact.php';
    require_once './views/Login.php';
    require_once './views/Signup.php';
    require_once './views/Search.php';
    require_once './views/Favorite.php';
    require_once './views/Userdata.php';

    require_once './views/component/Form.php';
    require_once './views/component/ImgGirl.php';
    require_once './views/component/Article.php';

    require_once './model/DBAction.php';

    // $this->dc = new DataController();
    $this->db = new DBAction();
  }


  /**
   * Undocumented function
   *
   * @param string $page
   * @return void
   */
  public function printView(string $page, array $articles = [])
  {
    // $page = 'resultado-busqueda';
    $options = ['column' => 'users.id', 'value' => 1];

    match ($page) {
      'perfil' => $this->setPage('', new Userdata(self::URL, 'seller', 'CMRR'), true),
      'favoritos' => $this->setPage('', new Favorite(self::URL, $this->db->getUserFavorites($_SESSION['user'])), true),
      'buscador' => $this->setPage('', new Search(self::URL, $this->db->getAllArticles()), true),
      'resultado-busqueda' => $this->setPage('', new Search(self::URL, $articles), true),
      'registro-cliente' => $this->setPage('', new Signup(self::URL, 'buyer'), false),
      'registro-empresa' => $this->setPage('', new Signup(self::URL, 'seller'), false),
      'contacto' => $this->setPage('', new Contact(self::URL), false),
      'login', 'out-session' => $this->setPage('login', new Login(self::URL), false),
      default => $this->setPage('', new Home(self::URL), false),
    };
  }

  /**
   * Crea e imprime en el navegador la página agregando las vistas pasadas por parámetro al documento
   *
   * @param string $hideLink    (Header)
   * @param ViewComponent $content Contenido de la página (Main)
   */
  private function setPage(string $hideLink, ViewComponent $content, bool $needSession)
  {
    $head = new Head();

    $linksHeader = (isset($_SESSION['user']))
      ? array_filter(self::LINKS, fn ($k) => $k !== $hideLink && $k !== 'login', ARRAY_FILTER_USE_KEY)
      : [self::LINKS['login']];
    $header = new Header($linksHeader);

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
