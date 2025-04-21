<?php

namespace App\model;
use PDO;

class Order
{
    private $validate;
    public function __construct(private $conn)
    {
    }

    public function createOrder(int $cart_id,string $address, string $payment_type,int $total, string $status = "pending")
    {
        $query = "insert into `order` (cart_id,address,status,payment_type,total) values (:cart_id,:address,:status,:payment_type,:total)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":cart_id", $cart_id);
        $stmt->bindValue(":address", $address);
        $stmt->bindValue(":payment_type", $payment_type);
        $stmt->bindValue(":total", $total);
        $stmt->bindValue(":status", $status);
      
    if ($stmt->execute()) {
        return $this->conn->lastInsertId();
    } else {
        echo "Something went wrong while creating the order.";
        return false;
    }
    }

    public function getOrderId($cart_id): array
    {
        $cartId = $cart_id["id"];
        $query = "select id from order where cart_id = :cartId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":cartId", $cartId);
        $stmt->execute();
        $orderId = $stmt->fetchColumn();
        return $orderId;
    }
   
}
