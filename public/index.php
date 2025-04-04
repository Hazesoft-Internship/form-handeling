<?php

require_once  __DIR__ . "/../vendor/autoload.php";

use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Sessions\Sessions;


$url = $_SERVER['REQUEST_URI'];



switch ($url) {
    case '/logout':
        (new Sessions())->destroySession();
        header("Location: /login");
        break;
    case '/login':
        require_once __DIR__ . '/../src/Views/login.php';
        break;

    case '/login/auth':
        (new UserController())->loginUser();
        break;

    case '/signup':
        require_once __DIR__ . '/../src/Views/signup.php';
        break;

    case '/signup/register':
        (new UserController())->registerUser();
        break;

    case '/home':
        require_once __DIR__ . '/../src/Views/home.php';
        break;

    case '/product':
        require_once __DIR__ . '/../src/Views/addProduct.php';
        break;

    case '/product/add':
        (new ProductController())->addProduct();
        break;

    case '/product/list':
        require_once __DIR__ . '/../src/Views/listproduct.php';
        break;

    case '/product/del':
        require_once __DIR__ . '/../src/Views/deleteProduct.php';
        break;

    case '/product/delete':
        (new ProductController())->deleteProduct();
        break;

    case '/product/upd':
        require_once __DIR__ . '/../src/Views/updateProduct.php';
        break;
    case '/product/update':
        (new ProductController())->updateProduct();
        break;
    default:
        echo "404 Not Found";
}
