<?php

use Hazesoft\Formhandeling\Controllers\ProductController;
use Hazesoft\Formhandeling\Controllers\AuthController;
use Hazesoft\Formhandeling\Controllers\CartController;

//Authentication routes
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'handleLogout']);

// Product Routes
$router->get('/', [ProductController::class, 'dashboard']);
$router->get('/products', [ProductController::class, 'products']);
$router->get('/my_products', [ProductController::class, 'myProducts']);
$router->get('/product/{id}', [ProductController::class, 'productDetail']);
$router->get('/add_product', [ProductController::class, 'addProduct']);
$router->post('/add_product', [ProductController::class, 'addProduct']);
$router->get('/product/{id}/update_product', [ProductController::class, 'updateProduct']);
$router->post('/product/{id}/update_product', [ProductController::class, 'updateProduct']);
$router->post('/product/{id}/delete_product', [ProductController::class, 'deleteProduct']);
$router->get('/api/products', [ProductController::class, 'getAllProducts']);

//Cart Routes
$router->get('/cart/{id}',[CartController::class, 'viewCart']);
$router->post('/cart/addItems',[CartController::class, 'addtoCart']);
$router->get('/cartitem/{id}',[CartController::class, 'cartItemDetail']);

