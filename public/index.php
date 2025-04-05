<?php
require("../vendor/autoload.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
use App\router\UserRoute;
use App\controller\UserController;
use App\controller\ProductController;
use App\controller\HomeController;

$router = new UserRoute();
$router->get("/",[HomeController::class,"index"]);
$router->get("/login",[HomeController::class,"login"]);
$router->get("/UpdateProduct",[ProductController::class,"getSingleProduct"]);
$router->get("/product",[ProductController::class,"getAllProducts"]);
$router->get("/add-product",[HomeController::class,"addProduct"]);
$router->get("/my-profile",[ProductController::class,"getUserProducts"]);
$router->get("/insertUser",[UserController::class,"insertCsv"]);
$router->post("/register",[UserController::class,"register"]);
$router->post("/login",[UserController::class,"login"]);
$router->post("/add-product",[ProductController::class,"addProduct"]);
$router->post("/delete-product",[ProductController::class,"deleteProduct"]);
$router->post("/update-product",[ProductController::class,"updateProduct"]);
$router->post("/logout",[UserController::class,"logout"]);
$router->handle();
