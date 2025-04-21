<?php

namespace App\model;
use PDO;

class OrderItem
{
    public function __construct(private $conn)
    {
    }

    public function createOrderItem(int $order_id,int $product_id, int $quantity,int $unit_price, int $total_price)
    {
        $query = "insert into order_item (order_id,product_id,qty,unit_price,total_price) values (:order_id,:product_id,:qty,:unit_price,:total_price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":order_id", $order_id);
        $stmt->bindValue(":product_id", $product_id);
        $stmt->bindValue(":qty", $quantity);
        $stmt->bindValue(":unit_price", $unit_price);
        $stmt->bindValue(":total_price", $total_price);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "something went wrong while adding a product";
        }
    }
}
