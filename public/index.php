<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once  __DIR__ . "/../vendor/autoload.php";

use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Router\Router;
use App\Sessions\Sessions;


// $url = $_SERVER['REQUEST_URI'];



// switch ($url) {
//     case '/logout':
//         (new Sessions())->destroySession();
//         header("Location: /login");
//         break;
//     case '/login':
//         require_once __DIR__ . '/../src/Views/login.php';
//         break;

//     case '/login/auth':
//         (new UserController())->loginUser();
//         break;

//     case '/signup':
//         require_once __DIR__ . '/../src/Views/signup.php';
//         break;

//     case '/signup/register':
//         (new UserController())->registerUser();
//         break;

//     case '/home':
//         require_once __DIR__ . '/../src/Views/home.php';
//         break;

//     case '/addProduct':
//         require_once __DIR__ . '/../src/Views/addProduct.php';
//         break;

//     case '/product/add':
//         (new ProductController())->addProduct();
//         break;

//     case '/listproducts':
//         require_once __DIR__ . '/../src/Views/listproducts.php';
//         break;



//     case '/product/delete':
//         (new ProductController())->deleteProduct();
//         break;

//     case '/myproducts':
//         require_once __DIR__ . '/../src/Views/myproducts.php';
//         break;
//     case '/product/update':
//         (new ProductController())->updateProduct();
//         break;
//     default:
//         echo "404 Not Found";
// }




$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestUri = explode('?', $requestUri)[0];

$router = new Router();

$router->route();
