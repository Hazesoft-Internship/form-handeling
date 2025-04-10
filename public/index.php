<?php

ini_set('display_errors', 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

use Hazesoft\Formhandeling\Core\Router;
use Hazesoft\Formhandeling\Core\Request;


require_once '../vendor/autoload.php';

$request = new Request();

$router = new Router($request);

require_once '../routes/web.php';

$router->resolve();
