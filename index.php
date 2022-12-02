<?php

require_once 'init.php';

/**
 * Obtiene los datos enviados al servidor, normalmente formularios
 */
if (isset($_POST['action'])) {
  match ($_POST['action']) {
    'login' => $dc->login(),
    'search' => $dc->searchFilterArticle(),
    'signup-buyer', 'signup-seller' => $dc->signup(),
    'addarticle' => $dc->uploadArticle(),
    'userdata' => $dc->updateUserdata(),
    'change-favorites' => $dc->changeFavorites(),
    'contact' => $dc->contact(),
    default => '',
  };
  exit();
}

/**
 * Obtiene los parámetros pasados por la URL, se usa con el icono de cerrar sesión
 */
if (isset($_GET['action'])) {
  match ($_GET['action']) {
    'logout' => $dc->logout(),
    default => '',
  };
  exit();
}

/**
 * Si no hay envío de una acción cargamos la vista de inicio 
 */
$vc->printView('home');
