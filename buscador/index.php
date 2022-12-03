<?php

require_once '../init.php';

$user = $dc->needSession();
$vc->printView('search', $dc->getArticles('all'));

