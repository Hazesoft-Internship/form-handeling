<?php

use ECommerce\Controllers\CartController\CartController;
use ECommerce\Controllers\ProductController\ProductController;
use ECommerce\Controllers\UserController\LogInController;
use ECommerce\Controllers\UserController\LogOutController;
use ECommerce\Controllers\UserController\SignUpController;
use ECommerce\Middlewares\SessionMiddleware;

return [
    "GET" => [
        '/' => function () {
            echo "Hello from index";
        },
        '/login' => [LogInController::class, 'getLoginPage'],
        '/signup' => [SignUpController::class, 'getSignUpPage'],
        '/add-products' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'getAddProductPage']
        ],
        '/update-products' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'getUpdateProductPage']
        ],
        '/allproducts' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'getAllProductPage']
        ],
        '/myproducts' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'getMyProductPage']
        ],
        '/mycart' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [CartController::class, 'getMyCartPage']
        ],
        '/api/get-allproducts' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'getAllProduct']
        ]
    ],
    "POST" => [
        '/login-submit' => [LogInController::class, 'handleLoginForm'],
        '/signup-submit' => [SignUpController::class, 'handleSignUpForm'],
        '/add-product-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'handleAddProductForm']
        ],
        '/update-product-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'handleUpdateProductForm']
        ],
        '/view-allproducts-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'handleListAllProduct']
        ],
        '/view-myproducts-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'handleListMyProduct']
        ],
        '/add-to-cart-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [CartController::class, 'handleAddItemtoCart']
        ],
        '/delete-cart-item' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [CartController::class, 'handleDeleteCartItem']
        ],
        '/delete-product-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [ProductController::class, 'handleDeleteProduct']
        ],
        '/logout-submit' => [
            "middleware" => [SessionMiddleware::class],
            "handler" => [LogOutController::class, 'handleLogOut']
        ]
    ]
];
