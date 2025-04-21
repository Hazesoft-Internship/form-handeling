<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Services\Connection;
use Exception;

class Order
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function insertOrderItems($orderItemsArray)
    {
        try {

            [$orderId, $productId, $quantity, $unitPrice, $totalPriceAfterTax] = $orderItemsArray;

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $query = "INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price_after_tax, created_at, updated_at) VALUES (:order_id, :product_id, :quantity, :unit_price, :total_price_after_tax, :created_at, :updated_at)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit_price', $unitPrice);
            $stmt->bindParam(':total_price_after_tax', $totalPriceAfterTax);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);

            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }

    public function insertOrders($ordersArray)
    {
        try {
            [$cartId, $address, $status, $paymentType, $tax, $total] = $ordersArray;

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // Added created_at and updated_at columns
            $query = "INSERT INTO orders (cart_id, address, status, payment_type, tax, total, created_at, updated_at) VALUES (:cart_id, :address, :status, :payment_type, :tax, :total, :created_at, :updated_at)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cart_id', $cartId);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':payment_type', $paymentType);
            $stmt->bindParam(':tax', $tax);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);

            return $stmt->execute();
        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
            return false;
        }
    }
}