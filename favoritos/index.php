<?php

require_once '../init.php';

$vc->printView('favorites', $dc->getArticles('favorites'));
