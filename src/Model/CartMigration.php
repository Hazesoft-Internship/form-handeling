<?php

namespace Lattefront\FormHandeling\Model;

use PDO;
use Lattefront\FormHandeling\Db\DbConnection;

class CartMigration
{
    private $conn;
    function __construct(DbConnection $dbConnection)
    {
        $this->conn = $dbConnection->getConnection();
    }

    public function migrateFromSession($sessionCart, $cartId): void
    {
        foreach ($sessionCart as $productId => $quantity) {
            $stmt = $this->conn->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->bindValue(1, $cartId, PDO::PARAM_INT);
            $stmt->bindValue(2, $productId, PDO::PARAM_INT);
            $stmt->execute();
            $existing = $stmt->fetch();

            if ($existing) {
                $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?");
                $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
                $stmt->bindValue(2, $cartId, PDO::PARAM_INT);
                $stmt->bindValue(3, $productId, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id,price, quantity) VALUES (?, ?,?, ?)");
                $stmt->bindValue(1, $cartId, PDO::PARAM_INT);
                $stmt->bindValue(2, $productId, PDO::PARAM_INT);
                $stmt->bindValue(3, $_SESSION['cart'][$productId]['price'], PDO::PARAM_INT); // Assuming price is stored in session cart
                $stmt->bindValue(4, $quantity, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        unset($_SESSION['cart']); // Clear the session cart after migration
    }
}
