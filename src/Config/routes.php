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
        '/home' => isAuthenticated() ? [UserController::class, 'homePage'] : function () {
            header('Location:/login');
        },
        '/' => [UserController::class, 'landingPage'],
        //if not authenticated show loginpage
        '/login' => !isAuthenticated() ? [UserController::class, 'loginPage'] : function () {
            header('Location: /home');
        },
        '/signup' => !isAuthenticated() ? [UserController::class, 'registerPage'] : function () {
            header('Location:/home');
        },
        '/add-product' => isAuthenticated() ? [ProductController::class, 'addProductPage'] : function () {
            header('Location:/login');
        },
        // '/products' => [ProductController::class, 'listProductsPage'],
        '/my-products' => isAuthenticated() ? [ProductController::class, 'myProductsPage'] : function () {
            header('Location:/login');
        },
        '/api/product' => [ProductController::class, 'productJsonPage']

    ],
    "POST" => [
        //  POST routes here
        '/logout' => [UserController::class, 'logout'],
        '/login' => [UserController::class, 'loginUser'],
        '/signup' => !isAuthenticated() ? [UserController::class, 'registerUser'] : [UserController::class, 'homePage'],
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
