<?php

require_once '../config/dbConnection.php';

use HazeSoft\Backend\formHandeling\config\DatabaseConnection;

class Product
{

    private $dbConnection;
    public function __construct(private $database = new DatabaseConnection())
    {
        $this->dbConnection = $this->database->connectDB();
    }

    public function addProduct($productName, $productPrice, $productQuantity)
    {
        session_start();
        $userID = $_SESSION['userID'];
        $addProductQuery = "INSERT INTO products (userID,name, price, quantity) VALUES ('$userID','$productName', '$productPrice', '$productQuantity')";
        $addProduct = mysqli_query($this->dbConnection, $addProductQuery);

        if (!$addProduct) {
            echo "Failed to add product";
        }

        echo "Product added successfully";
    }
}
