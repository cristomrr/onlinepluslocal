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

const URL_SERVER = './server.php';

// TODO: Temporal para probar las páginas, cuando se haga la parte del servidor lo hará el controller

$head = new Head();
$footer = new Footer();

$page = (isset($_GET['page']))
  ? $_GET['page']
  : '';


function setPage(Head $head, Header $header, string $content, Footer $footer)
{

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


switch ($page) {



  case 'perfil-vendedor':
    $header = new Header(['search', 'favorite', 'seller', 'logout']);
    $viewUserdata = new Userdata(URL_SERVER, 'seller', 'CMRR Soluciones');
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;

  case 'perfil-cliente':
    $header = new Header(['search','favorite', 'buyer', 'logout']);
    $viewUserdata = new Userdata(URL_SERVER, 'buyer', 'Cristo');
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;


  case 'favoritos':
    $header = new Header(['search','favorite', 'seller', 'buyer', 'logout']);
    $viewUserdata = new Favorite(URL_SERVER);
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;

  case 'buscador':
    $header = new Header(['search','favorite', 'seller', 'buyer', 'logout']);
    $viewUserdata = new Search(URL_SERVER);
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;

  case 'signupb':
    $header = new Header(['login']);
    $viewUserdata = new Signup(URL_SERVER, 'buyer');
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;

  case 'signups':
    $header = new Header(['login']);
    $viewUserdata = new Signup(URL_SERVER, 'seller');
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;

  case 'contacto':
    $header = new Header(['search','favorite', 'login', 'logout', 'seller', 'buyer']);
    $viewUserdata = new Contact(URL_SERVER);
    setPage($head, $header, $viewUserdata->getCode(), $footer);
    break;

  case 'login':
    $header = new Header(['favorite', 'login']);
    $viewLogin = new Login(URL_SERVER);
    setPage($head, $header, $viewLogin->getCode(), $footer);
    break;

  default:
    $header = new Header(['login']);
    $viewHome = new Home();
    setPage($head, $header, $viewHome->getCode(), $footer);
    break;
}
