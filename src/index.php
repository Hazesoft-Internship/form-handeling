<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Hazesoft\Backend\Routers\Router;
use Hazesoft\Backend\Services\TableCreation;

$table = TableCreation::getInstance();
$table->createUsersTableIfNotExists();
$table->createProductsTableIfNotExists();
$table->createCartItemsTableIfNotExists();
$table->createCartsTableIfNotExists();
$table->createOrderItemsTableIfNotExists();
$table->createOrdersTableIfNotExists();

// Routing logic
$routes = require_once(__DIR__ . '/Config/routes.php');

$router = new Router();

$router->loadRoutes($routes);
$router->resolve();