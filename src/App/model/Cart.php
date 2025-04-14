<?php

namespace App\model;

use App\database\Database;
use App\session\Session;
use PDO;

class Cart
{
    private $session;
    public function __construct(private $conn)
    {
        $this->session = Session::getInstance();
    }

    public function createCart($userId)
    {

        $stmt = $this->conn->prepare("insert into cart (user_id) values (:userId)");
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getCart()
    {
        $stmt = $this->conn->prepare("select * from cart where user_id = :userId");
        $stmt->bindValue(":userId", $this->session->getSession("user_id"), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
