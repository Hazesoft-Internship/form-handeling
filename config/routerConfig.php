<?php

use Lattefront\FormHandeling\Controller\AuthController;
use Lattefront\FormHandeling\Controller\UserController;
use Lattefront\FormHandeling\Controller\ProductController;
use Lattefront\FormHandeling\Middleware\Authmiddleware as loginCheck;

return [

    'GET' => [
        '/' => [ProductController::class, 'getallproduct'],
        '/dashboard' => loginCheck::wrap([UserController::class, 'dashboard']),

        '/signup' => [AuthController::class, 'signUp'],
        '/login' => [AuthController::class, 'loginpage'],
        '/addproduct' => loginCheck::wrap([ProductController::class, 'addproductpage']),
        '/logout' => [AuthController::class, 'logout'],

        '/productlist' => loginCheck::wrap([ProductController::class, 'myproductlist']),
        '/viewallproducts' => [ProductController::class, 'getallproduct'],

        '/updateproduct' => loginCheck::wrap([ProductController::class, 'updateproductpage']),
    ],
    'POST' => [
        '/signup' => [UserController::class, 'insertUser'],
        '/login' => [AuthController::class, 'login'],
        '/addproduct' => [ProductController::class, 'addproduct'],
        '/updateproduct' => [ProductController::class, 'updateproduct'],
        '/deleteproduct' => [ProductController::class, 'deleteproduct'],
    ]

];
