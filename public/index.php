<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Lattefront\FormHandeling\Router\Router;
use Lattefront\FormHandeling\Controller\Controllers;

$router = new Router();

$router->get('/', [Controllers::class, 'dashboard']);
$router->get('/dashboard', [Controllers::class, 'dashboard']);
$router->get('/signup', [Controllers::class, 'signUp']);
$router->post('/signup', [Controllers::class, 'insertUser']);
$router->get('/login', [Controllers::class, 'loginpage']);
$router->post('/login', [Controllers::class, 'login']);
$router->get('/addproduct', [Controllers::class, 'addproductpage']);
$router->post('/addproduct', [Controllers::class, 'addproduct']);
$router->get('/logout', [Controllers::class, 'logout']);
$router->get('/productlist', [Controllers::class, 'productlist']);
$router->get('/updateproduct', [Controllers::class, 'updateproductpage']); //need to made dynamic
$router->post('/updateproduct', [Controllers::class, 'updateproduct']);
// $router->getId('/deleteproduct/:id', function ($id) {
//     Controllers::deleteproduct($id);
// });
$router->get('/deleteproduct', [Controllers::class, 'deleteproductpage']);
$router->post('/deleteproduct', [Controllers::class, 'deleteproduct']);


$router->dispatch();
