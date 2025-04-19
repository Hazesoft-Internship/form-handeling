<?php

use Lattefront\FormHandeling\Controller\AuthController;
use Lattefront\FormHandeling\Controller\UserController;
use Lattefront\FormHandeling\Controller\ProductController;
use Lattefront\FormHandeling\Middleware\Authmiddleware as loginCheck;
use Lattefront\FormHandeling\Controller\CartController;

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
        '/viewcart' => ([CartController::class, 'viewcart']),
        '/updatecart' => loginCheck::wrap([CartController::class, 'updatecartpage']),
    ],
    'POST' => [
        '/signup' => [AuthController::class, 'insertUser'],
        '/login' => [AuthController::class, 'login'],
        '/addproduct' => loginCheck::wrap([ProductController::class, 'addproduct']),
        '/updateproduct' => loginCheck::wrap([ProductController::class, 'updateproduct']),
        '/deleteproduct' => loginCheck::wrap([ProductController::class, 'deleteproduct']),
        '/addtocart' => ([CartController::class, 'addproductCart']),
        '/updatecart' => loginCheck::wrap([CartController::class, 'updateCart']),
        '/deletecart' => ([CartController::class, 'removecartproduct']),
    ]

];
