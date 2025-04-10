<?php

namespace Hazesoft\Formhandeling\Controllers;

use Exception;
use Hazesoft\Formhandeling\Models\Product;
use Hazesoft\Formhandeling\Services\Session;
use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Services\DateFormatter;
use Hazesoft\Formhandeling\Validation\ProductValidation;
use Hazesoft\Formhandeling\Exception\ValidationException;


$session = Session::getInstance();

$session->start();

class ProductController
{
    use DateFormatter;
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function addProduct(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $validation = new ProductValidation();

                try {
                    $validateData = $validation->validateForm($_POST);
                    $product_name = $validateData['name'];
                    $product_quantity = $validateData['quantity'];
                    $product_price = $validateData['price'];
                    try {
                        $this->productModel->addProduct($product_name, $product_quantity, $product_price);
                        header("Location: /my_products");
                        exit();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } catch (ValidationException $validationException) {
                    View::render('add_product', [
                        'errors' => $validationException->getMessage(),
                        'postData' => $_POST
                    ]);
                }
            } else {
                View::render('add_product');
            }
        } catch (Exception $e) {
            echo "Unexpected error: " . $e->getMessage();
        }
    }

    public function dashboard()
    {

        $products = $this->productModel->getProductsForDashboard();
        foreach ($products as &$product) {
            $product['created_at'] = $this->convertDateTime($product['created_at']);
            $product['updated_at'] = $this->convertDateTime($product['updated_at']);
        }
        View::render('dashboard', ['products' => $products]);
    }

    public function products()
    {
        $products = $this->productModel->getOtherUsersProducts();
        foreach ($products as &$product) {
            $product['created_at'] = $this->convertDateTime($product['created_at']);
            $product['updated_at'] = $this->convertDateTime($product['updated_at']);
        }
        View::render('products', ['products' => $products]);
    }

    public function myProducts()
    {
        $products = $this->productModel->getUserProducts();
        View::render('my_products', ['products' => $products]);
    }

    public function productDetail($id)
    {
        $product = $this->productModel->getProductById($id);
        $product['created_at'] = $this->convertDateTime($product['created_at']);
        $product['updated_at'] = $this->convertDateTime($product['updated_at']);

        View::render('product_detail', ['product' => $product]);
    }

    public function updateProduct($id): void
    {

        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $validation = new ProductValidation();

                try {
                    $validateData = $validation->validateForm($_POST);

                    $product_name = $validateData['name'];
                    $product_quantity = $validateData['quantity'];
                    $product_price = $validateData['price'];

                    $this->productModel->updateProduct($id, $product_name, $product_quantity, $product_price);

                    header("Location: /product/{$id}");
                    exit();
                } catch (ValidationException $validationException) {
                    View::render('update_product', [
                        'errors' => $validationException->getMessage(),
                        'postData' => $_POST
                    ]);
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                $product = $this->productModel->getProductById($id);

                if (!$product) {
                    echo "Product not found!";
                    exit();
                }

                View::render('update_product', [
                    'product' => $product
                ]);
            }
        } catch (Exception $e) {
            echo "Unexpected error: " . $e->getMessage();
        }
    }

    public function deleteProduct($id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->productModel->deleteProduct($id);
            header("Location: /my_products");
            exit();
        }
    }

    public function getAllProducts()
    {
        $products = $this->productModel->getProductsForDashboard();

        header('Content-Type: application/json');

        echo json_encode($products, JSON_PRETTY_PRINT);
    }
}
