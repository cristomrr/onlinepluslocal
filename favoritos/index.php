<?php

require_once '../init.php';

$user = $dc->needSession();
$vc->printView('favorites', $dc->getArticles('favorites'));
