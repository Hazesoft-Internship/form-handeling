<?php

header("Content-Type:application/json");

use App\Controllers\ProductController;

$product = (new ProductController())->listProducts();


echo json_encode($product, JSON_PRETTY_PRINT);
