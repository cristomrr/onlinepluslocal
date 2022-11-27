<?php

require_once './controller/ViewController.php';
require_once './controller/DataController.php';

$vc = new ViewController();
$dc = new DataController();

if (isset($_POST['formname'])) {

  match ($_POST['formname']) {
    'login' => $dc->login(),
    'search' => $dc->searchArticle(),
    'signup-buyer', 'signup-seller' => $dc->signup(),
    'addarticle' => '',
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
