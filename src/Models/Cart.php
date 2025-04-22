<?php

namespace Hazesoft\Formhandeling\Models;


class Cart extends BaseModel
{

    public function getOrCreateCart($userid): int
    {
        try {
            $stmt = $this->connection->prepare("SELECT id FROM cart WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $userid, \PDO::PARAM_INT);
            $stmt->execute();
            $cart = $stmt->fetch();

            if ($cart) {
                return $cart['id'];
            }
            $stmt = $this->connection->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
            $stmt->bindParam(':user_id', $userid, \PDO::PARAM_INT);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to get or create cart: " . $e->getMessage());
        }
    }
}
