<?php
require_once './controller/ViewController.php';

$session = false;
if (isset($_POST['on-session'])) {
  if ($_POST['on-session'] === 'on') {
    $session = true;
  } elseif ($_POST['on-session'] === 'off') {
    $session = false;
  }
}

$page = (isset($_GET['page']))
  ? strip_tags(trim($_GET['page']))
  : 'home';

$vc = new ViewController();
$vc->printView($page, $session);
