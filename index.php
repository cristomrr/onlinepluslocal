<?php

require_once 'init.php';

/**
 * Obtiene los datos enviados al servidor, normalmente formularios
 */
if (isset($_POST['action'])) {
  match ($_POST['action']) {
    'login' => $dc->login($vc),
    'search' => $vc->printView('search', $dc->getArticles('all')),
    'signup-buyer', 'signup-seller' => $dc->signup($vc),
    'addarticle' => $dc->uploadArticle(),
    'userdata' => $dc->updateUserdata(),
    'change-favorites' => $dc->changeFavorites(),
    'contact' => $dc->contact($vc),
    default => '',
  };
  exit();
}

/**
 * Obtiene los parámetros pasados por la URL, se usa con el icono de cerrar sesión
 * TODO: MODIFICAR RUTA AL SERVIDOR EN PRODUCCIÓN
 */
if (isset($_GET['action'])) {
  match ($_GET['action']) {
    // 'logout' => header('location: https://onlinepluslocal.es'),
    'logout' => header('location: http://localhost:3000'),
    default => '',
  };
  exit();
}

/**
 * Si no hay parámetros es porque se solicitó una vista, la carga según el parámetro de la URL
 * TODO: recordar hacer rutas amigables con .htaccess
 */
// $page = (isset($_GET['page']))
//   ? strip_tags(trim($_GET['page']))
//   : 'home';

$vc->printView('home');
// match($page) {
//   'contact'=> 
// }
