<?php

namespace Hazesoft\Formhandeling\Models;

class Order extends BaseModel
{

    public function getOrderByCartId(int $cartId): ?int
    {
        try {
            $stmt = $this->connection->prepare("SELECT id FROM orders WHERE cart_id = :cart_id");
            $stmt->bindParam(':cart_id', $cartId, \PDO::PARAM_INT);
            $stmt->execute();
            $order = $stmt->fetch();

            return $order ? (int)$order['id'] : null;
        } catch (\PDOException $e) {
            throw new \Exception("Failed to fetch order: " . $e->getMessage());
        }
    }

    public function createOrder(int $cartId, string $address, string $status, string $paymentType, float $totalAmount): int
    {
        try {
            $stmt = $this->connection->prepare("
            INSERT INTO orders (cart_id, address, status, payment_type, total_amount) 
            VALUES (:cart_id, :address, :status, :payment_type, :total_amount)
        ");
            $stmt->bindParam(':cart_id', $cartId, \PDO::PARAM_INT);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':payment_type', $paymentType);
            $stmt->bindParam(':total_amount', $totalAmount);
            $stmt->execute();

            return $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to create order: " . $e->getMessage());
        }
    }
}
