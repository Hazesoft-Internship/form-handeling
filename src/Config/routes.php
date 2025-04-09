<?php

use App\Controllers\UserController;

use App\Controllers\ViewController;
use App\Controllers\ProductController;
use App\Sessions\Sessions;

function isAuthenticated()
{
    return (Sessions::getInstance())->hasSession('user');
}

return [
    "GET" => [
        // if authenticated show homepage
        '/home' =>  isAuthenticated() ? [ViewController::class, 'homePage'] : function () {
            header('location:/login');
        },
        '/' => [ViewController::class, 'listProductsPage'],
        //if not authenticated show loginpage
        '/login' => !isAuthenticated() ? [ViewController::class, 'loginPage'] : function () {
            header('Location: /home');
        },
        '/signup' => !isAuthenticated() ? [ViewController::class, 'registerPage'] : function () {
            header('Location:/home');
        },
        '/add-product' => isAuthenticated() ? [ViewController::class, 'addProductPage'] : function () {
            header('Location:/login');
        },
        '/products' => [ViewController::class, 'listProductsPage'],
        '/my-products' => isAuthenticated() ? [ViewController::class, 'myProductsPage'] : function () {
            header('Location:/login');
        },
        '/api/product' => [ViewController::class, 'productJsonPage']

    ],
    "POST" => [
        //  POST routes here
        '/logout' => [UserController::class, 'logout'],
        '/login' => [UserController::class, 'loginUser'],
        '/signup' => !isAuthenticated() ? [UserController::class, 'registerUser'] : [ViewController::class, 'homePage'],
        '/add-product' => isAuthenticated() ? [ProductController::class, 'addProduct'] : function () {
            header('Location:/login');
        },
        '/delete-product' => isAuthenticated() ? [ProductController::class, 'deleteProduct'] :
            function () {
                header('Location:/login');
            },
        '/update-product' => isAuthenticated() ? [ProductController::class, 'updateProduct'] : function () {
            header('Location:/login');
        },

    ]


];
