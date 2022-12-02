<?php

require_once '../init.php';

$user = $dc->needSession();
$vc->printView('userdata', $user);