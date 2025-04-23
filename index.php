<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use ECommerce\Routers\Router;

Dotenv::createUnsafeImmutable(__DIR__)->load();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$routes = require_once __DIR__ . '/src/Config/routes.php';

$router = new Router();

$router->loadRoutes($routes);
$router->dispatch($request);
