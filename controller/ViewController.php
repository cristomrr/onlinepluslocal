<?php

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

class ViewController
{

  private const URL_SERVER = './server.php';

  public function __construct()
  {
  }


  /**
   * Crea e imprime en el navegador la página agregando las vistas pasadas por parámetro al documento
   *
   * @param Header $header Cabecera de la página (Header)
   * @param string $content Contenido de la página (Main)
   */
  private function setPage(Header $header, string $content)
  {
    $head = new Head();
    $footer = new Footer();

    $doc = '<!DOCTYPE html>
            <html lang="es">
              ' . $head->getCode() . '
              <body>
                ' . $header->getCode() . '
                <main class="content-body">
                  ' . $content . '
                </main>
                ' . $footer->getCode() . '
              </body>
            </html>';

    echo $doc;
  }

  /**
   * Undocumented function
   *
   * @param string $page
   * @return void
   */
  public function printView(string $page)
  {
    $user = 'buyer';

    match ($page) {
      'perfil-vendedor' => $this->viewUserdataSeller($user),
      'perfil-cliente' => $this->viewUserdataBuyer($user),
      'favoritos' => $this->viewFavorite($user),
      'buscador' => $this->viewSearch($user),
      'registro-cliente' => $this->viewSignupBuyer($user),
      'registro-vendedor' => $this->viewSignupSeller($user),
      'contacto' => $this->viewContact($user),
      'login', 'out-session' => $this->viewLogin($user),
      default =>
      $this->viewHome(),
    };
  }


  /**
   * Vista de la página de registro vendedores
   */
  private function viewUserdataSeller()
  {
    $header = new Header(['search', 'favorite', 'logout']);
    $viewUserdataSeller = new Userdata(self::URL_SERVER, 'seller', 'CMRR Soluciones');
    $this->setPage($header, $viewUserdataSeller->getCode());
  }


  /**
   * Vista de la página de registro clientes
   */
  private function viewUserdataBuyer()
  {
    $header = new Header(['search', 'favorite', 'logout']);
    $viewUserdataBuyer = new Userdata(self::URL_SERVER, 'buyer', 'Cristo');
    $this->setPage($header, $viewUserdataBuyer->getCode());
  }


  /**
   * Vista de la página de favoritos
   * 
   * @param string $user El tipo de cliente que inició sesión. Disponibles: buyer o seller
   */
  private function viewFavorite($user)
  {
    $data_tmp = file_get_contents('./test/data-product/articles_testing.json');
    $products = json_decode($data_tmp, true);

    $header = new Header(['search', $user, 'logout']);
    $viewFavorite = new Favorite($products);
    $this->setPage($header, $viewFavorite->getCode());
  }


  /**
   * Vista de la página de búsqueda
   * 
   * @param string $user El tipo de cliente que inició sesión. Disponibles: buyer o seller
   */
  private function viewSearch($user)
  {
    $data_tmp = file_get_contents('./test/data-product/articles_testing.json');
    $products = json_decode($data_tmp, true);

    $header =   new Header(['favorite', $user, 'logout']);
    $viewSearch = new Search(self::URL_SERVER, $products);
    $this->setPage($header, $viewSearch->getCode());
  }


  /**
   * Vista de la página de registro cliente
   */
  private function viewSignupBuyer()
  {
    $header =   new Header(['login']);
    $viewSignupBuyer = new Signup(self::URL_SERVER, 'buyer');
    $this->setPage($header, $viewSignupBuyer->getCode());
  }


  /**
   * Vista de la página de registro vendedor
   */
  private function viewSignupSeller()
  {
    $header = new Header(['login']);
    $viewSignupSeller = new Signup(self::URL_SERVER, 'seller');
    $this->setPage($header, $viewSignupSeller->getCode());
  }


  /**
   * Vista de la página de Contacto
   */
  private function viewContact($user)
  {
    $header =  new Header(['search', 'favorite', $user, 'logout']);
    $viewContact = new Contact(self::URL_SERVER);
    $this->setPage($header, $viewContact->getCode());
  }


  /**
   * Vista de la página de login
   */
  private function viewLogin($user)
  {
    $header = new Header(['search', 'favorite', $user, 'logout']);
    $viewLogin = new Login(self::URL_SERVER);
    $this->setPage($header, $viewLogin->getCode());
  }


  /**
   * Vista de la página de inicio
   */
  private function viewHome()
  {
    $header = new Header(['login']);
    $viewHome = new Home();
    $this->setPage($header, $viewHome->getCode());
  }
}
