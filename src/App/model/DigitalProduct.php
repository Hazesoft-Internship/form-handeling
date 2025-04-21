<?php
namespace App\model;

use App\database\Database;
use App\model\ProductInterface;
use PDO;

class DigitalProduct implements ProductInterface
{
    private $type = "digital";
    private $conn;
    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }
    public function displayAllProducts()
    {
      

    }
    public function calculateProduct($price, $quantity)
    {
        $discount = 0;
        if($quantity >= 12) {
            $discount = 0.2;
        } elseif($quantity >= 6) {
            $discount = 0.1;
        }
        return $price - ($discount * $price);
    }

    public function paymentMethodOfProducts()
    {

    }


}