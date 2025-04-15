<?php

declare(strict_types=1);

namespace src\Models;

use PDO;
use src\Config\DB;
use src\Exceptions\DatabaseException;
use src\Exceptions\ValidationException;

class Product
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function addProduct(int $user_id, string $product_name, float $price, int $quantity): void
    {
        if (empty($product_name)) {
            throw new ValidationException("Product name is required.");
        }

        $stmt = $this->conn->prepare("
            INSERT INTO products (user_id, product_name, price, quantity)
            VALUES (?, ?, ?, ?)
        ");

        try {
            $stmt->execute([$user_id, $product_name, $price, $quantity]);
        } catch (\PDOException $e) {
            throw new DatabaseException("Error adding product: " . $e->getMessage());
        }
    }

    public function getUserProducts(int $user_id): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOtherUsersProducts(int $userId): array {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE user_id != ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
