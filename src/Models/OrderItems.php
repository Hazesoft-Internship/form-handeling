<?php

namespace Hazesoft\Formhandeling\Models;

class OrderItems extends BaseModel
{
    public function orderItems($orderId, $productId, $quantity, $unitPrice, $totalPrice): void
    {
        try {
            $stmt = $this->connection->prepare("INSERT into order_items (order_id, product_id, quantity, unit_price, total_price) VALUES(:order_id, :product_id, :quantity, :unit_price, :total_price)");
            $stmt->bindParam(":order_id", $orderId);
            $stmt->bindParam(":product_id", $productId);
            $stmt->bindParam(":quantity", $quantity);
            $stmt->bindParam(":unit_price", $unitPrice);
            $stmt->bindParam(":total_price", $totalPrice);
            $stmt->execute();
        } catch (\PDOException $error) {
            throw new \Exception("Failer to add Order :" . $error->getMessage());
        }
    }

    public function displayOrder($orderId): mixed
    {
        try {
            $stmt = $this->connection->prepare(" 
                SELECT oi.*, p.name AS product_name
                FROM order_items oi
                JOIN products p ON oi.product_id = p.productid
                WHERE oi.order_id = :order_id");
            $stmt->bindParam(":order_id", $orderId);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $error) {
            throw new \Exception("Failer to display Order :" . $error->getMessage());
        }
    }
}
