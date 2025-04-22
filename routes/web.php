<?php

use Hazesoft\Formhandeling\Controllers\ProductController;
use Hazesoft\Formhandeling\Controllers\AuthController;
use Hazesoft\Formhandeling\Controllers\CartController;
use Hazesoft\Formhandeling\Controllers\CartItemController;
use Hazesoft\Formhandeling\Controllers\CheckoutController;
use Hazesoft\Formhandeling\Controllers\OrderController;

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
$router->get('/cart/{id}', [CartController::class, 'viewCart']);
$router->post('/cart/addItems', [CartItemController::class, 'addtoCart']);
$router->post('/cart/update-all', [CartItemController::class, 'updateAllCartItems']);
$router->post('/cart/delete', [CartItemController::class, 'deleteCartItem']);

//checkout
$router->get('/checkout', [CheckoutController::class, 'viewCheckout']);

//orders
$router->get('/order/detail', [OrderController::class, 'displayOrder']);
$router->post('/order', [OrderController::class, 'placeOrder']);
