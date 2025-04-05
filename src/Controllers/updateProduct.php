<?php

namespace Hazesoft\Backend\Controllers;

use Hazesoft\Backend\Config\SessionHandler;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Validations\ProductValidation;

$productObject = new Product();
$session = new SessionHandler();

$productId = $session->getSession("productId");
if (isset($productId) && ($_SERVER["REQUEST_METHOD"] === 'POST')) {
    try {
        $product = [
            $_POST['productName'] ?? '',
            $_POST['productPrice'] ?? '',
            $_POST['productQuantity'] ?? ''
        ];

        var_dump($product);

        $session->removeSession("productId");

        // Initialize validation
        $productValidator = new ProductValidation();

        // Sanitization of inputArray
        $sanitizedProductArray = $productValidator->sanitizeArray($product);
        $isProductValid = $productValidator->validateUserInput($sanitizedProductArray);

        if ($isProductValid) {
            echo "Product validation successful <br>";

            $updateProductObject = new Product();

            $updateProductObject->updateProduct($productId, $product);
        } else {
            echo "Product validation failed <br>";
        }
    } catch (Exception $exception) {
        echo "Error: " . $exception->getMessage();
    }
} else {
    var_dump($_POST['productId']);
    echo "Error updating product <br>";
}
