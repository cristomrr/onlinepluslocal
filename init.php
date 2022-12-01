<?php

require_once 'server/vendor/autoload.php';

require_once 'server/config/ENV.php';
require_once 'server/config/ERROR_CODE.php';

require_once 'server/model/DBConnect.php';
require_once 'server/model/DBAction.php';

require_once 'server/views/ViewComponent.php';

require_once 'server/views/component/Head.php';
require_once 'server/views/component/Header.php';
require_once 'server/views/component/Footer.php';

require_once 'server/views/component/Form.php';
require_once 'server/views/component/ImgGirl.php';
require_once 'server/views/component/Article.php';

require_once 'server/views/Errors.php';
require_once 'server/views/Home.php';
require_once 'server/views/Contact.php';
require_once 'server/views/Login.php';
require_once 'server/views/Signup.php';
require_once 'server/views/Search.php';
require_once 'server/views/Favorite.php';
require_once 'server/views/Userdata.php';

require_once 'server/controller/ViewController.php';
require_once 'server/controller/DataController.php';

$vc = new ViewController();
$dc = new DataController();
