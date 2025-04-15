<?php

require '../vendor/autoload.php';

use src\Config\Router;

$router = new Router();

// Define routes
$router->add('GET', '/', 'ProductController@index');
$router->add('GET', '/login', 'UserController@login');
$router->add('POST', '/login', 'UserController@login');
$router->add('GET', '/products', 'ProductController@index');
$router->add('GET', '/products/all', 'ProductController@all');
$router->add('POST', '/cart/add', 'CartController@add');
$router->add('GET', '/cart', 'CartController@view');
$router->add('POST', '/cart/update', 'CartController@update');

$router->dispatch();