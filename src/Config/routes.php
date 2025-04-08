<?php

use App\Controllers\UserController;

use App\Controllers\RouteController;
use App\Controllers\ProductController;

return [
    "GET" => [
        // Add your GET routes here
        '/home' =>  [RouteController::class, 'homePage'],
        '/' => [RouteController::class, 'listProductsPage'],
        '/login' => [RouteController::class, 'loginPage'],
        '/signup' => [RouteController::class, 'registerPage'],
        '/product' => [ProductController::class, 'productPage'],
        '/addproduct' => [RouteController::class, 'addProductPage'],
        '/listproducts' => [RouteController::class, 'listProductsPage'],
        '/myproducts' => [RouteController::class, 'myProductsPage'],

    ],
    "POST" => [
        // Add your POST routes here
        '/logout' => [UserController::class, 'logout'],
        '/login' => [UserController::class, 'loginUser'],
        '/signup' => [UserController::class, 'registerUser'],
        '/addproduct' => [ProductController::class, 'addProduct'],
        '/product/delete' => [ProductController::class, 'deleteProduct'],
        '/product/update' => [ProductController::class, 'updateProduct'],

    ]


];
