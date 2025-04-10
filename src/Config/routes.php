<?php

use Hazesoft\Backend\Controllers\UserController\LogInController;
use Hazesoft\Backend\Controllers\ProductController\ProductController;
use Hazesoft\Backend\Controllers\UserController\SignUpController;
use Hazesoft\Backend\Controllers\Frontend\HomePageController;

return [
    "GET" => [
        '/' => [HomePageController::class, 'getHomepage'],
        '/login' => [LogInController::class, 'getLoginPage'],
        '/signup' => [LogInController::class, 'getSignUpPage'],
        '/products' => [ProductController::class, 'getProductsPage'],
        '/products/create' => [ProductController::class, 'getAddProductPage'],
        '/products/update' => [ProductController::class, 'getUpdateProductPage'],
        ],
        
    "POST" => [
        '/login' => [LogInController::class, 'handleLoginForm'],
        '/signup' => [SignUpController::class, 'handleSignUpForm'],
        '/products' => [ProductController::class, 'handleAddProductForm'],  // products url => add-product
        '/products/update' => [ProductController::class, 'handleUpdateProductForm'],
        '/products/delete' => [ProductController::class, 'handleDeleteProduct'],
        '/logout' => [LogInController::class, 'handleLogout']
    ],
];