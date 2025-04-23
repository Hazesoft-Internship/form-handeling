<?php

use App\Controllers\Product\ProductController;
use App\Sessions\Sessions;
use App\Controllers\Cart\CartController;
use App\Controllers\Order\OrderController;
use App\Controllers\User\UserController;


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
        '/cart' => isAuthenticated() ? [CartController::class, 'cartPage'] : function () {
            header('Location:/login');
        },
        '/api/product' => [ProductController::class, 'productJsonPage'],
        '/checkout' => isAuthenticated() ? [OrderController::class, 'checkoutPage'] : function () {
            header('Location:/login');
        },

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
        '/cart' => isAuthenticated() ? [CartController::class, 'addToCart'] : function () {
            header('Location:/login');
        },
        '/remove-from-cart' => isAuthenticated() ? [CartController::class, 'removeFromCart'] : function () {
            header('Location:/login');
        },
        '/update-cart' => isAuthenticated() ? [CartController::class, 'updateCartQuantity'] : function () {
            header('Location:/login');
        },
        '/order' => isAuthenticated() ? [OrderController::class, 'createOrder'] : function () {
            header('Location:/login');
        },
    ]


];
