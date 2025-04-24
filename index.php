<?php

require __DIR__. "/vendor/autoload.php";

use App\controller\ProductController;
use App\controller\UserController;
use App\controller\CartController;
use App\config\Route;

$route = new Route();
//these contain the get request for the user controller.
$route->get('/', [UserController::class, 'getLogin']);
$route->get('/signup', [UserController::class, 'getSignUp']);
$route->get('/productManagement', [UserController::class, 'getProductManagement']);
$route->get('/uploadUser', [UserController::class, 'uploadUser']);

//these contain the post request for the user controller.
$route->post('/login', [UserController::class, 'handleLogin']);
$route->post('/signup', [UserController::class, 'handleSignUp']);
$route->post('/logout', [UserController::class, 'handleLogOut']);

//these contain the get request for the product controller.
$route->get('/addProduct', [ProductController::class, 'getAddProduct']);
$route->get('/viewAllProduct', [ProductController::class, 'handleViewAllProduct']);

//these contain the post request for the product controller.
$route->post('/addProduct', [ProductController::class, 'handleAddProduct']);
$route->get('/viewYourProduct', [ProductController::class, 'handleViewYourProduct']);
$route->post('/viewYourProduct',     [ProductController::class, 'handleViewYourProduct']);
$route->post('/updateProduct', [ProductController::class, 'updateProduct']);
$route->post('/deleteProduct', [ProductController::class, 'deleteProduct']);
$route->post('/readProduct', [ProductController::class, 'showReadUpdate']);

//these are the route for the cart operations
$route->post('/viewYourCart', [CartController::class, 'showYourCart']);
$route->get('/viewYourCart', [CartController::class, 'showYourCart']);
$route->post('/createCart', [CartController::class, 'createCart']);
$route->post('/uploadCart', [CartController::class, 'uploadCart']);
$route->post('/readCartUpdate', [CartController::class, 'showUpdateCart']);
$route->post('/deleteCart', [CartController::class, 'deleteCart']);
$route->post('/updateCart', [CartController::class, 'updateCart']);

$route->resolve();
