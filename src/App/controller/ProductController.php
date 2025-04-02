<?php

namespace App\controller;

use App\model\Product;
use App\Exception\CustomException;

class ProductController
{
    
    public function __construct(private $conn, private $validate)
    {
    }

    public function addProduct(string $name, int $price, int $quantity, int $userId)
    {
        if (empty($name) || empty($price) || empty($quantity)) {
            echo "something went wrong while adding product";
            return;
        } else {
            $product = new Product($this->conn);
            $product->addProduct($name, $price, $quantity, $userId);
            header("Location: ../view/product.php");
        }
    }

    public function getSingleProduct(int $id) {
        if(empty($id)) {
            echo "invalid id";
        } else {
            $product = new Product($this->conn);
            $singleProduct = $product->getSingleProduct($id);
        }
        return $singleProduct;   
    }

    public function updateProduct($productId, $productName, $productQuantity, $productPrice) {
        $datas["name"] = $productName;
        $datas["price"] = $productPrice;
        $datas["quantity"] = $productQuantity;
        $datas["id"] = $productId;

        try {
            $this->validate->validator($datas);
            $product = new Product($this->conn);
            $product->updateProduct($productId, $productName, $productQuantity, $productPrice);


        } catch(CustomException $exception) {
            
            echo $exception->getMessage() . $exception->getCode();
            foreach ($exception->getTheError() as $errorTitle => $errorMessage) {
                echo $errorMessage;
            }

        }
    }

   

    
}
