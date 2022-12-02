<?php

require_once '../init.php';

$vc->printView('error', ['code' => ERROR_CODE::CONNECT_DB]);
