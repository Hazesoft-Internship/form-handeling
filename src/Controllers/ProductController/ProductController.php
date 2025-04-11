<?php

namespace Hazesoft\Backend\Controllers\ProductController;

use Exception;
use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Validations\ProductValidation;
use Hazesoft\Backend\Validations\ValidationException;
use Hazesoft\Backend\Services\Session;

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
                echo($exception->getMessage());
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
                    echo("Product validation error");
                }
            } catch (Exception $exception) {
                echo("Product validation error: " . $exception->getMessage());
            }
        }
    }

    public function handleUpdateProductData(): array
    {
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $currentProduct = $this->product->getProductById($productId);

            return [
                'productId' => $productId,
                'currentProduct' => $currentProduct
            ];
        } else {
            echo "Error updating product";
            exit;
        }
    }
    public function handleProductsData(): array
    {
        // Get session instance
        $session = Session::getInstance();

        // Authentication check
        if (!$session->hasSession("isLoggedIn")) {
            header("Location: /");
            exit("Authentication failed");
        }

        $userId = $session->getSession("userId");

        // Get products data
        $myProducts = $this->product->getUserProducts($userId);
        $otherProducts = $this->product->getOtherProducts($userId);

        return [
            'session' => $session,
            'userId' => $userId,
            'myProducts' => $myProducts,
            'otherProducts' => $otherProducts
        ];
    }

    public function getAddProductPage()
    {
        return require_once(__DIR__ . '/../../Views/product-form.html');
    }

    public function getUpdateProductPage()
    {
        $viewData = $this->handleUpdateProductData();
        extract($viewData);
        return require_once(__DIR__ . '/../../Views/update-product-form.php');
    }

    public function getProductsPage()
    {
        $viewData = $this->handleProductsData();
        extract($viewData);
        return require_once(__DIR__ . '/../../Views/show-products.php');
    }
}



