<?php

namespace Lattefront\FormHandeling\Model;

use PDO;

class OrderModel extends model
{

    public function CreateOrder($cartid, $address, $status, $paymentType, $tax, $total): int
    {
        $sql = "INSERT INTO orders ( cartid, address, status,paymenttype,tax,total) VALUES (?, ?, ?, ?, ?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $cartid, PDO::PARAM_INT);
        $stmt->bindParam(2, $address, PDO::PARAM_STR);
        $stmt->bindParam(3, $status, PDO::PARAM_STR);
        $stmt->bindParam(4, $paymentType, PDO::PARAM_STR);
        $stmt->bindParam(5, $tax, PDO::PARAM_INT);
        $stmt->bindParam(6, $total, PDO::PARAM_INT);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }
}
