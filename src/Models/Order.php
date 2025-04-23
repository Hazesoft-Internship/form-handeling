<?php

namespace ECommerce\Models;

use ECommerce\Models\ModelDBConnection;

use PDO;
use PDOStatement;

final class Order extends ModelDBConnection
{
    public function createOrder(int $cartID, string $address, string $paymentType, int $tax, int $grandTotal): PDOStatement|string
    {
        try {
            $createOrderQuery = 'INSERT INTO orders(cartID,address,paymentType,tax,total) VALUES (:cartID,:address,:paymentType,:tax,:grandTotal)';
            $statement = $this->dbConnection->prepare($createOrderQuery);
            $statement->bindParam(':cartID', $cartID);
            $statement->bindParam(':address', $address);
            $statement->bindParam(':paymentType', $paymentType);
            $statement->bindParam(':tax', $tax);
            $statement->bindParam(':grandTotal', $grandTotal);

            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage()();
        }
    }

    public function getOrderID(int $cartID)
    {
        try {
            $getOrderIDQuery = 'SELECT id FROM orders WHERE cartID = :cartID ORDER BY id DESC LIMIT 1';
            $statement = $this->dbConnection->prepare($getOrderIDQuery);
            $statement->bindParam(':cartID', $cartID);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage()();
        }
    }

    public function getProductTypeWithCartID(int $cartID): array|string
    {
        try {
            $productTypeWithCartIDType = "SELECT cartItems.productID, products.type 
                                          FROM cartItems 
                                          INNER JOIN cartItems.productID = products.id 
                                          WHERE cartItems.cartID = :cartID";
            $statement = $this->dbConnection->prepare($productTypeWithCartIDType);
            $statement->bindParam(':cartID', $cartID);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getOrderHistory(int $userID)
    {
        try {
            $orderHistoryQuery = 'SELECT o.address,o.status,o.paymentType,o.tax,o.total,o.createdAt 
                                  FROM orders As o 
                                  INNER JOIN carts ON o.cartID = carts.id 
                                  WHERE carts.userID=:userID';
            $statement = $this->dbConnection->prepare($orderHistoryQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
