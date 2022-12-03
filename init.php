<?php

require_once 'server/vendor/autoload.php';
// Valores necesarios en todo el sitio web (imagenes, credenciales a base de datos, ...)
require_once 'server/config/ENV.php';
// Conexión a la base de datos y peticiones
require_once 'server/model/DBConnect.php';
require_once 'server/model/DBAction.php';
// Clase padre de los objetos Views
require_once 'server/views/ViewComponent.php';
// Vistas de los componentes que irán en todas las vistas
require_once 'server/views/component/Head.php';
require_once 'server/views/component/Header.php';
require_once 'server/views/component/Footer.php';
// Componentes de las vistas (también vistas)
require_once 'server/views/component/Form.php';
require_once 'server/views/component/ImgGirl.php';
require_once 'server/views/component/Article.php';
// Vistas del sitio 
require_once 'server/views/Mail.php';
require_once 'server/views/Errors.php';
require_once 'server/views/Home.php';
require_once 'server/views/Contact.php';
require_once 'server/views/Login.php';
require_once 'server/views/Signup.php';
require_once 'server/views/Search.php';
require_once 'server/views/Favorite.php';
require_once 'server/views/Userdata.php';
// Controladores, encargados de comunicar vistas y datos
require_once 'server/controller/ViewController.php';
require_once 'server/controller/DataController.php';

$vc = new ViewController();
$dc = new DataController();
