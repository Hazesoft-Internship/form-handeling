<?php

namespace Hazesoft\Backend\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Hazesoft\Backend\Config\SessionHandler;

$session = new SessionHandler();

$session->destroySession();
header("Location: /");
