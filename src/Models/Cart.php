<?php

declare(strict_types=1);

namespace src\Models;

use src\Config\DB;
use src\Exceptions\DatabaseException;
use src\Exceptions\ValidationException;
use PDO;

class Cart {
    private PDO $conn;

    public function __construct() {
        $this->conn = DB::getConnection();
    }

    public function addItem(int $userId, int $productId, int $quantity): void {
        $product = $this->getProduct($productId);
        if ($product['user_id'] === $userId) {
            throw new ValidationException("Cannot add your own product to cart.");
        }
        if ($quantity > $product['quantity']) {
            throw new ValidationException("Quantity exceeds stock.");
        }

        $existing = $this->getCartItem($userId, $productId);
        if ($existing) {
            $newQuantity = $existing['quantity'] + $quantity;
            if ($newQuantity > $product['quantity']) {
                throw new ValidationException("Total quantity exceeds stock.");
            }
            $this->updateItem($userId, $productId, $newQuantity);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function updateItem(int $userId, int $productId, int $quantity): void {
        $product = $this->getProduct($productId);
        if ($quantity > $product['quantity']) {
            throw new ValidationException("Quantity exceeds stock.");
        }

        $stmt = $this->conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $userId, $productId]);
    }

    public function getCartItems(int $userId): array {
        $stmt = $this->conn->prepare("
            SELECT c.product_id, c.quantity, p.product_name, p.price, p.quantity as stock
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getProduct(int $productId): array {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) throw new ValidationException("Product not found.");
        return $product;
    }

    private function getCartItem(int $userId, int $productId): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}