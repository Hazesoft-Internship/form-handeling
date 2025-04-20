<?php

namespace Hazesoft\Backend\Models;

use Exception;
use Hazesoft\Backend\Services\Connection;

class CartItems
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function insertCartItems($productId, $productQuantity, $userId)
    {

        try {
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $query = "INSERT into cart_items (user_id, product_id, quantity, created_at, updated_at) VALUES (:user_id, :product_id, :quantity, :created_at, :updated_at)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':quantity', $productQuantity);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);

            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function getCartItems($userId)
    {
        try {
            $query = "SELECT 
                p.id AS product_id,
                p.name AS product_name,
                ci.quantity AS added_quantity,
                p.price AS product_price,
                (p.price * ci.quantity) AS item_total_price
            FROM
                products AS p
            JOIN 
                cart_items AS ci ON p.id = ci.product_id
            WHERE
                ci.user_id = :user_id
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            return $stmt->fetchAll(); // Return cartItems as an array

        } catch (Exception $exception) {
            echo ($exception->getMessage());
            return [];
        }
    }

    public function getItemById($productId, $userId)
    {
        try {
            $query = "SELECT * from cart_items WHERE user_id = :user_id AND product_id = :product_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();

            return $stmt->fetch();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return [];
        }
    }

    public function updateCartItem($productId, $userId, $productQuantity)
    {
        try {
            $updated_at = date('Y-m-d H:i:s');

            $query = "UPDATE cart_items
            SET
                quantity = :quantity,
                updated_at = :updated_at
            WHERE 
                user_id = :user_id AND product_id = :product_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':quantity', $productQuantity);
            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':product_id', $productId);

            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function deleteCartItem($productId, $userId)
    {
        try {
            $query = "DELETE FROM cart_items WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':product_id', $productId);
            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function getProductType(int $userId)
    {
        try {
            $query = "SELECT DISTINCT p.type
                      FROM products AS p
                      JOIN cart_items AS ci ON p.id = ci.product_id
                      WHERE ci.user_id = :userId";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (Exception $exception) {
            echo ($exception->getMessage());
            return null;
        }
    }
}
