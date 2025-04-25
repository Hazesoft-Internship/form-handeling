<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Services\Connection;
use Exception;

class Carts extends BaseModel
{
    public function createCart($userId)
    {
        try {
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $query = "INSERT INTO carts (user_id, created_at, updated_at) VALUES (:userId, :created_at, :updated_at)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);
            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function doesCartExists($userId)
    {
        try {

            $query = "SELECT id FROM carts WHERE user_id = :userId";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId);

            $stmt->execute();

            $row = $stmt->fetch();

            $cartId = $row["id"] ?? false;

            if ($cartId) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function updateCart($userId)
    {
        try {
            $updated_at = date('Y-m-d H:i:s');

            $query = "UPDATE carts SET updated_at = :updated_at WHERE user_id = :userId";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->bindParam(':userId', $userId);
            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function getCartId($userId)
    {
        try {

            $query = "SELECT id FROM carts WHERE user_id = :userId";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $row = $stmt->fetch();
            $cartId = $row["id"];

            return $cartId;
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return null;
        }
    }
}
