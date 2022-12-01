<?php

require_once '../init.php';

$vc->printView('search', $dc->getArticles('all'));
