<?php

use Hazesoft\Backend\Controllers\CartController\CartController;
use Hazesoft\Backend\Controllers\UserController\LogInController;
use Hazesoft\Backend\Controllers\ProductController\ProductController;
use Hazesoft\Backend\Controllers\UserController\SignUpController;
use Hazesoft\Backend\Controllers\Frontend\HomePageController;
use Hazesoft\Backend\Controllers\OrderController\OrderController;

return [
    "GET" => [
        '/' => [HomePageController::class, 'getHomepage'],
        '/login' => [LogInController::class, 'getLoginPage'],
        '/signup' => [LogInController::class, 'getSignUpPage'],
        '/products' => [ProductController::class, 'getProductsPage'],
        '/products/create' => [ProductController::class, 'getAddProductPage'],
        '/products/update' => [ProductController::class, 'getUpdateProductPage'],
        '/cart/insert' => [CartController::class, 'getInsertCartProductPage'],
        '/cart/update' => [CartController::class, 'getInsertCartProductPage'],
        '/cart/details' => [CartController::class, 'getCartDetailsPage'],
        '/order/checkout' => [OrderController::class, 'getCheckoutPage']
        ],
        
    "POST" => [
        '/login' => [LogInController::class, 'handleLoginForm'],
        '/signup' => [SignUpController::class, 'handleSignUpForm'],
        '/products' => [ProductController::class, 'handleAddProductForm'],  // products url => add-product
        '/products/update' => [ProductController::class, 'handleUpdateProductForm'],
        '/products/delete' => [ProductController::class, 'handleDeleteProduct'],
        '/logout' => [LogInController::class, 'handleLogout'],
        '/cart/insert' => [CartController::class, 'handleInsertCartProductPage'],
        '/cart/delete' => [CartController::class, 'handleDeleteCartItem']
    ],
];