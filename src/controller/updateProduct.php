<?php
namespace App\controller;

require_once __DIR__."/../../vendor/autoload.php";
use App\connectDB\Database;

class updateProduct
{
    private int $id;
    private $conn;
    private float $updatedPrice;
    private int $updatedQuantity;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->updatedPrice = $_POST['updatedPrice'];
        $this->updatedQuantity = $_POST['updatedQuantity'];
        $this->id = $_POST['id'];
    }

    public function updateDB()
    {
        $query = "UPDATE products SET quantity=$this->updatedQuantity, price=$this->updatedPrice WHERE id=$this->id";
        if(($this->conn->query($query)) == TRUE)
        {
            echo "updated sucessfully";
        }
        else
        {
            echo "update failed";
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $updatedProd1 = new updateProduct();
    $updatedProd1->updateDB();
}
