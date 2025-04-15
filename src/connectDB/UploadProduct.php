<?php
namespace App\connectDB;
require_once __DIR__."/../../vendor/autoload.php";
use App\connectDB\Database;
use App\session\session;

class UploadProduct
{
    private $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function createProduct($productName, $quantity, $price): void
    {
        $userID = session::getInstance()->get("userID");
        $stmt = $this->connection->prepare("INSERT INTO products(userID, productName, quantity, price) VALUES (:userID, :productName, :quantity, :price)");

        if (!$stmt) {
            throw new RuntimeException("Unable to prepare the statement for product");
        }
        $stmt->bindParam(':userID',$userID);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        if (!$stmt->execute()) {
            throw new RuntimeException("Unable to execute the query for Product addition");
        }
        else {
            echo "<br>Product sucessfully added to database<br>";
        }
    }
}

?>