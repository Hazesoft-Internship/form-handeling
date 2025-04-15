<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Hazesoft\Backend\Routers\Router;
use Hazesoft\Backend\Services\Migration;

$migration = Migration::getInstance();
$migration->createUsersTableIfNotExists();
$migration->createProductsTableIfNotExists();
$migration->createCartItemsTableIfNotExists();

// $request = $_SERVER['REQUEST_URI'];

// Remove any query string
// $request = parse_url($request, PHP_URL_PATH);

// Routing logic
$routes = require_once(__DIR__ . '/Config/routes.php');

$router = new Router();

$router->loadRoutes($routes);
$router->resolve();