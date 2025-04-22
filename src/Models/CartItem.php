<?php

namespace Hazesoft\Formhandeling\Models;

class CartItem extends BaseModel
{

    public function getCartItem($cartId, $productId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id");
            $stmt->bindParam(':cart_id', $cartId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to get cart item: " . $e->getMessage());
        }
    }

    public function addCartItem($cartId, $productId, $quantity): mixed
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
            $stmt->bindParam(':cart_id', $cartId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':quantity', $quantity);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to add cart item: " . $e->getMessage());
        }
    }


    public function updateCartItemQuantity($itemId, $quantity): bool
    {
        try {
            $stmt = $this->connection->prepare("UPDATE cart_items SET quantity = :quantity WHERE id = :id");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':id', $itemId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to update cart item quantity: " . $e->getMessage());
        }
    }


    public function getCartItems($cartId): array
    {
        try {
            $stmt = $this->connection->prepare("
            SELECT ci.product_id, ci.id, ci.quantity AS cartItemQuantity, p.name, p.price, (ci.quantity * p.price) AS total_price, p.types, p.quantity AS productQuantity
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.productid
            WHERE ci.cart_id = :cart_id
        ");
            $stmt->bindParam(':cart_id', $cartId);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to fetch cart items with names: " . $e->getMessage());
        }
    }


    public function getCartItemById($cart_item_id): mixed
    {
        try {
            $stmt = $this->connection->prepare("
            SELECT 
                ci.id AS cart_item_id,
                ci.cart_id,
                ci.quantity,
                ci.product_id,
                ci.created_at,
                ci.updated_at,
                p.name AS product_name,
                p.price,
                (ci.quantity * p.price) AS total_price
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.productid
            WHERE ci.id = :cart_item_id
        ");
            $stmt->bindParam(':cart_item_id', $cart_item_id, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Failed to fetch cart item by ID: " . $e->getMessage());
        }
    }


    public function deleteCart($cart_item_id): void
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM cart_items WHERE id = :id");
            $stmt->bindParam(':id', $cart_item_id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to delete cart item: " . $e->getMessage());
        }
    }

    public function clearCart(int $cartId): void
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
            $stmt->bindParam(':cart_id', $cartId, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to clear cart: " . $e->getMessage());
        }
    }
}
