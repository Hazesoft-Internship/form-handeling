<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use Hazesoft\Formhandeling\Core\Router;
use Hazesoft\Formhandeling\Core\Request;

ini_set('display_errors', 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

$request = new Request();
$router = new Router($request);

require_once '../routes/web.php';

$router->resolve();
