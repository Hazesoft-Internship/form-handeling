<?php
require("../vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
error_reporting(E_ALL);
ini_set('display_errors', 1);
use App\router\UserRoute;
use App\controller\UserController;
use App\controller\ProductController;
use App\controller\CartController;
use App\controller\HomeController;
use App\model\CartItem;
use App\database\Database;

$router = new UserRoute();
$router->get("/",[UserController::class,"displayRegister"]);
$router->get("/login",[UserController::class,"displayLogin"]);
$router->get("/UpdateProduct",[ProductController::class,"getSingleProduct"]);
$router->get("/product",[ProductController::class,"getAllProducts"]);
$router->get("/add-product",[ProductController::class,"displayAddProduct"]);
$router->get("/my-profile",[ProductController::class,"getUserProducts"]);
$router->get("/insertUser",[UserController::class,"insertCsv"]);
$router->get("/cart",[CartController::class,"getUserCartItem"]);
$router->get("/checkout",[CartController::class,"displayCheckoutPage"]);
$router->post("/register",[UserController::class,"register"]);
$router->post("/login",[UserController::class,"login"]);
$router->post("/add-product",[ProductController::class,"addProduct"]);
$router->post("/delete-product",[ProductController::class,"deleteProduct"]);
$router->post("/update-product",[ProductController::class,"updateProduct"]);
$router->post("/logout",[UserController::class,"logout"]);
$router->post("/cart",[CartController::class,"addToCart"]);
$router->post("/updateCart",[CartController::class,"updateCartQuantity"]);
$router->handle();

// $db = Database::getInstance();
// $conn = $db->getConnection();
// $mo = new CartItem($conn);
// $store = $mo->getCartItem(5);