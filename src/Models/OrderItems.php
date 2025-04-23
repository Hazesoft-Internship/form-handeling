<?php

namespace ECommerce\Models;

use PDOStatement;

final class OrderItems extends ModelDBConnection
{
    public function addOrderItems(int $orderID, int $productID, int $quantity, int $totalPrice): PDOStatement|string
    {
        try {
            $addOrderItemsQuery = 'INSERT INTO orderItems(orderID,productID,quantity,totalPrice) VALUES (:orderID,:productID,:quantity,:totalPrice)';
            $statement = $this->dbConnection->prepare($addOrderItemsQuery);
            $statement->bindParam(':orderID', $orderID);
            $statement->bindParam(':productID', $productID);
            $statement->bindParam(':quantity', $quantity);
            $statement->bindParam(':totalPrice', $totalPrice);
            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
