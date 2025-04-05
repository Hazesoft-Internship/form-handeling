<?php

namespace Hazesoft\Backend\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Hazesoft\Backend\Models\Product;

if(isset($_GET['id'])){
    $productId = $_GET['id'];

    $productObject = new Product();
    $productObject->deleteProduct($productId);
        
} else {
    echo "Product deletion error";
}