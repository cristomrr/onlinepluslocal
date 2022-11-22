<?php
require_once './controller/ViewController.php';

$page = (isset($_GET['page']))
  ? strip_tags(trim($_GET['page']))
  : 'home';

$vc = new ViewController();
$vc->printView($page);
