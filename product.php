<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("./src/App/config/database.php");
require_once("./src/App/model/Product.php");

require_once("./src/App/controller/ProductController.php");

use App\controller\ProductController;


$conn = database::connectDB();
$user = new ProductController($conn);
$user->addProduct();
