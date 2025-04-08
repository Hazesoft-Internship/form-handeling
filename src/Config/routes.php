<?php

use App\Controllers\UserController;

use App\Controllers\RouteController;
use App\Controllers\ProductController;

return [
    ['url' => '/', 'controller' => [RouteController::class, 'listProductsPage'], 'method' => 'GET'],
    [
        'url' => '/logout',
        'controller' => [UserController::class, 'logout'],
        'method' => 'POST',
    ],
    [
        'url' => '/login',
        'controller' => [UserController::class, 'loginUser'],
        'method' => 'POST',
    ],
    [
        'url' => '/login',
        'controller' => [RouteController::class, 'loginPage'],
        'method' => 'GET',
    ],
    [
        'url' => '/signup',
        'controller' => [RouteController::class, 'registerPage'],
        'method' => 'GET',
    ],
    [
        'url' => '/signup',
        'controller' => [UserController::class, 'registerUser'],
        'method' => 'POST',
    ],
    [
        'url' => '/home',
        'controller' => [RouteController::class, 'homePage'],
        'method' => 'GET',
    ],
    [
        'url' => '/addproduct',
        'controller' => [RouteController::class, 'addProductPage'],
        'method' => 'GET',
    ],
    [
        'url' => '/addproduct',
        'controller' => [ProductController::class, 'addProduct'],
        'method' => 'POST',
    ],
    [
        'url' => '/listproducts',
        'controller' => [RouteController::class, 'listProductsPage'],
        'method' => 'GET',
    ],
    [
        'url' => '/myproducts',
        'controller' => [RouteController::class, 'myProductsPage'],
        'method' => 'GET',
    ],
    [
        'url' => '/product/delete',
        'controller' => [ProductController::class, 'deleteProduct'],
        'method' => 'POST',
    ],

    [
        'url' => '/product/update',
        'controller' => [ProductController::class, 'updateProduct'],
        'method' => 'POST',
    ],

];
