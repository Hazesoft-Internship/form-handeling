<?php

use ECommerce\Controllers\ProductController\ProductController;
use ECommerce\Controllers\UserController\LogInController;
use ECommerce\Controllers\UserController\LogOutController;
use ECommerce\Controllers\UserController\SignUpController;

return [
    "GET" => [
        '/' => function () {
            echo "Hello from index";
        },
        '/login' => [LogInController::class, 'getLoginPage'],
        '/signup' => [SignUpController::class, 'getSignUpPage'],
        '/add-products' => [ProductController::class, 'getAddProductPage'],
        '/update-products' => [ProductController::class, 'getUpdateProductPage'],
        '/allproducts' => [ProductController::class, 'getAllProductPage'],
        '/myproducts' => [ProductController::class, 'getMyProductPage']
    ],
    "POST" => [
        '/login-submit' => [LogInController::class, 'handleLoginForm'],
        '/signup-submit' => [SignUpController::class, 'handleSignUpForm'],
        '/add-product-submit' => [ProductController::class, 'handleAddProductForm'],
        '/update-product-submit' => [ProductController::class, 'handleUpdateProductForm'],
        '/view-allproducts-submit' => [ProductController::class, 'handleListAllProduct'],
        '/view-myproducts-submit' => [ProductController::class, 'handleListMyProduct'],
        '/delete-product-submit' => [ProductController::class, 'handleDeleteProduct'],
        '/logout-submit' => [LogOutController::class, 'handleLogOut']
    ]
];
