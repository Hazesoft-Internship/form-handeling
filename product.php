<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("./vendor/autoload.php");

use App\model\Product;
use App\config\database;

$db= database::getInstance();
$conn = $db->getConnection();
$product = new Product($conn);
$result = $product->getSingleProduct(1);
var_dump($result);
