<?php

namespace Hazesoft\Backend\Controllers\ProductController;

use Exception;
use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Validations\ProductValidation;
use Hazesoft\Backend\Validations\ValidationException;

class ProductController
{
    private $product;
    private $productValidator;

    public function __construct()
    {
        $this->product = new Product();
        $this->productValidator = new ProductValidation();
    }

    public function handleUpdateProductForm(): void
    {
        if (isset($_POST['id'])) {
            $productId = $_POST['id'];
        } else {
            echo "Error updating product from ProductController";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            try {
                $product = [
                    $_POST['productName'] ?? '',
                    $_POST['productPrice'] ?? '',
                    $_POST['productQuantity'] ?? ''
                ];

                // Sanitization of inputArray
                $sanitizedProductArray = $this->productValidator->sanitizeArray($product);
                $isProductValid = $this->productValidator->validateUserInput($sanitizedProductArray);

                if ($isProductValid) {
                    echo "Product validation successful <br>";

                    $updateProductObject = new Product();

                    $updateProductObject->updateProduct($productId, $product);
                    header("Location: /products");
                } else {
                    echo "Product validation failed <br>";
                }
            } catch (Exception $exception) {
                echo "Error: " . $exception->getMessage();
            }
        } else {
            echo "Error updating product <br>";
        }
    }

    public function handleDeleteProduct(): void
    {
        if (isset($_POST['id'])) {
            $productId = $_POST['id'];
            $this->product->deleteProduct($productId);
            header("Location: /products");
        } else {
            echo "Error deleting product from ProductController";
        }
    }

    public function handleAddProductForm(): void
    {

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            try {
                // Capture form data
                $inputArray = [
                    $_POST['productName'] ?? '',
                    $_POST['productPrice'] ?? '',
                    $_POST['productQuantity'] ?? ''
                ];
            } catch (Exception $exception) {
                throw new ValidationException($exception->getMessage());
            }

            try {
                // Sanitization of inputArray
                $sanitizedInputArray = $this->productValidator->sanitizeArray($inputArray);
                $isProductValid = $this->productValidator->validateUserInput($sanitizedInputArray);

                if ($isProductValid) {
                    echo "Product validation successful <br>";

                    // send data to db
                    $insertProductObject = new Product();
                    $result = $insertProductObject->insertProductDetails($inputArray);
                    if ($result) {
                        echo "Product added successfully";
                        header("Location: /products");
                    } else {
                        echo "Product addition failed";
                    }
                } else {
                    throw new ValidationException("Product validation error");
                }
            } catch (Exception $exception) {
                throw new ValidationException("Product validation error: " . $exception->getMessage());
            }
        }
    }

    public function getAddProductPage()
    {
        return require_once(__DIR__ . '/../../Views/product-form.html');
    }

    public function getUpdateProductPage()
    {
        return require_once(__DIR__ . '/../../Views/update-product-form.php');
    }

    public function getProductsPage()
    {
        return require_once(__DIR__ . '/../../Views/show-products.php');
    }
}



