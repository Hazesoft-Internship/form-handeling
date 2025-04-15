<?php

require __DIR__. "/vendor/autoload.php";

use App\controller\ProductController;
use App\controller\UserController;
use App\config\Route;

$route = new Route();
//these contain the get request for the user controller.
$route->get('/', [UserController::class, 'getLogin']);
$route->get('/signup', [UserController::class, 'getSignUp']);
$route->get('/productManagement', [UserController::class, 'getProductManagement']);

//these contain the get request for the product controller.
$route->get('/addProduct', [ProductController::class, 'getAddProduct']);

//these contain the post request for the user controller.
$route->post('/login', [UserController::class, 'handleLogin']);
$route->post('/signup', [UserController::class, 'handleSignUp']);
$route->post('/logout', [UserController::class, 'handleLogOut']);

//these contain the get request for the product controller.
$route->post('/addProduct', [ProductController::class, 'handleAddProduct']);
$route->post('/viewAllProduct', [ProductController::class, 'handleViewAllProduct']);
$route->post('/viewYourProduct', [ProductController::class, 'handleViewYourProduct']);
$route->post('/updateProduct', [ProductController::class, 'updateProduct']);
$route->post('/deleteProduct', [ProductController::class, 'deleteProduct']);
$route->post('/readProduct', [ProductController::class, 'showReadUpdate']);

$route->resolve();
