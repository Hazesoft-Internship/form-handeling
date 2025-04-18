<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Db\DbConnection;
use PDO;

class  CartId
{
    private $conn;
    public function __construct(DbConnection $dbConnection)
    {
        $this->conn = $dbConnection->getConnection();
    }
    public function getCartId(int $userId)
    {
        $stmt = $this->conn->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $cartId = $stmt->fetchColumn();
        if ($cartId === false) {
            return null;
        }
        // print_r($cartId);
        return $cartId;
    }
}
