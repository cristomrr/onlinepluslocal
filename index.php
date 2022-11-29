<?php
require_once './ENV.php';

require_once './model/DBConnect.php';
require_once './model/DBAction.php';

require_once './views/ViewComponent.php';

require_once './views/component/Head.php';
require_once './views/component/Header.php';
require_once './views/component/Footer.php';

require_once './views/component/Form.php';
require_once './views/component/ImgGirl.php';
require_once './views/component/Article.php';

require_once './views/Home.php';
require_once './views/Contact.php';
require_once './views/Login.php';
require_once './views/Signup.php';
require_once './views/Search.php';
require_once './views/Favorite.php';
require_once './views/Userdata.php';

require_once './controller/ViewController.php';
require_once './controller/DataController.php';

$vc = new ViewController();
$dc = new DataController();


// $db = new DBAction();
// $db->setPasswdDB($db->getPasswordHash('ropa2022'), 1);


if (isset($_POST['action'])) {

  match ($_POST['action']) {
    'login' => $dc->login(),
    'search' => $dc->searchArticle(),
    'signup-buyer', 'signup-seller' => $dc->signup(),
    'addarticle' => $dc->uploadArticle(),
    'userdata' => $dc->updateUserdata(),
    'change-favorites' => $dc->changeFavorites(),
    default => '',
  };
  exit();
}

if (isset($_GET['action'])) {

  match ($_GET['action']) {
    'logout' => $dc->logout(),
    default => '',
  };
  exit();
}

$page = (isset($_GET['page']))
  ? strip_tags(trim($_GET['page']))
  : 'home';

$vc->printView($page);
