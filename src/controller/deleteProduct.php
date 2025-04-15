<?php
namespace App\controller;
require_once __DIR__."/../../vendor/autoload.php";
use App\connectDB\Database;

class deleteProduct
{
    private int $id;
    private $conn;
    private float $updatedPrice;
    private int $updatedQuantity;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();          
        $this->id = $_GET['id'];
    }

    public function deleteFromDB()
    {
        $sql = "DELETE FROM products WHERE id=$this->id";
        if(($this->conn->query($sql)) == TRUE)
        {
            echo "Deleted sucessfully";
        }
        else
        {
            echo "deletion failed";
        }
    }
}

    $deleteProd1 = new deleteProduct();
    $deleteProd1->deleteFromDB();
