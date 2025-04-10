<?php

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

use ayushtamang\FormHandeling\router\Router;
use ayushtamang\FormHandeling\database\Database;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$db = Database::getInstance();
$con = $db->getConnection();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = require __DIR__ . '/../src/config/routes.php';

$router = new Router();

$router->getRoutes($routes);
$router->resolve($requestUri);
