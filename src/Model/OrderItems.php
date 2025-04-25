<?php

namespace Lattefront\FormHandeling\Model;

use PDO;

class OrderItems extends Model
{
    public  function AddOrderItems($orderId, $productId, $quantity, $unitPrice): void
    {
        $sql = "INSERT INTO order_items ( order_id, product_id, quantity,unitPrice) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $orderId, PDO::PARAM_INT);
        $stmt->bindParam(2, $productId, PDO::PARAM_INT);
        $stmt->bindParam(3, $quantity, PDO::PARAM_INT);
        $stmt->bindParam(4, $unitPrice, PDO::PARAM_INT);

        if ($stmt->execute()) {
            
            echo "Order addded";
        }
    }
}
