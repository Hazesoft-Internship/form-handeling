<?php

namespace Hazesoft\Formhandeling\Models;

use Hazesoft\Formhandeling\Services\Database;
use Hazesoft\Formhandeling\Services\Session;
use PDO;


$session = Session::getInstance();

$session->start();

class CartItem
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getCartItem($cartId, $productId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addCartItem($cartId, $productId, $quantity)
    {
        $stmt = $this->connection->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    public function updateCartItemQuantity($itemId, $quantity)
    {
        $stmt = $this->connection->prepare("UPDATE cart_items SET quantity = :quantity WHERE id = :id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $itemId);
        return $stmt->execute();
    }

    public function getCartItemsName($cartId)
    {
        $stmt = $this->connection->prepare("
        SELECT ci.product_id, ci.id, p.name 
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.productid
        WHERE ci.cart_id = :cart_id
    ");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getCartItemsById($cart_item_id)
    {
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

        $stmt->bindParam(':cart_item_id', $cart_item_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
