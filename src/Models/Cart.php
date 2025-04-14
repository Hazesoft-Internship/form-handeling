<?php

namespace Hazesoft\Formhandeling\Models;

use Hazesoft\Formhandeling\Services\Database;
use Hazesoft\Formhandeling\Services\Session;
use Exception;
use PDO;
use PDOException;

$session = Session::getInstance();

$session->start();

class Cart
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getOrCreateCart($userid)
    {
        $stmt = $this->connection->prepare("SELECT id FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch();

        if ($cart) {
            return $cart['id'];
        }
        $stmt = $this->connection->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
        $stmt->bindParam(':user_id', $userid, PDO::PARAM_INT);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }
}
