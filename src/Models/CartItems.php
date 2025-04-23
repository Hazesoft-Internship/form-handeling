<?php

namespace ECommerce\Models;

use ECommerce\Models\ModelDBConnection;
use PDO;
use PDOStatement;

final class CartItems extends ModelDBConnection
{
    public function getCartItem(int $cartID, int $productID): array|string
    {
        try {
            $query = 'SELECT * FROM cartItems WHERE `cartID` = :cartID AND `productID` = :productID';
            $statement = $this->dbConnection->prepare($query);
            $statement->bindParam(':cartID', $cartID);
            $statement->bindParam(':productID', $productID);
            $statement->execute();
            
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCartItemsDetail(int $userID): array|string
    {
        try {
            $getCartItemsQuery = 'SELECT 
                                        cartItems.id,
                                        cartItems.cartID,
                                        products.id as productID,
                                        products.name, 
                                        products.price,
                                        products.type, 
                                        cartItems.quantity
                                  FROM carts
                                  INNER JOIN cartItems ON carts.id = cartItems.cartID
                                  INNER JOIN products ON cartItems.productID = products.id
                                  WHERE 
                                        carts.userID = :userID';

            $statement = $this->dbConnection->prepare($getCartItemsQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProductStock(int $id): array|string
    {
        try {
            $checkQuantityQuery = 'SELECT quantity FROM products WHERE id = :id';
            $statement = $this->dbConnection->prepare($checkQuantityQuery);
            $statement->bindParam(':id', $id);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateCartProductQuantity(int $quantity, int $id): PDOStatement|string
    {
        try {
            $updateQuery = 'UPDATE `cartItems` SET `quantity` = `quantity` + :quantity WHERE `id` = :id';
            $statement = $this->dbConnection->prepare($updateQuery);
            $statement->bindParam(':quantity', $quantity);
            $statement->bindParam(':id', $id);

            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addItemToCart(int $cartID, int $productID, int $quantity)
    {
        try {
            $insertQuery = 'INSERT INTO `cartItems` (`cartID`, `productID`, `quantity`) 
                            VALUES (:cartID, :productID, :quantity)';
            $statement = $this->dbConnection->prepare($insertQuery);
            $statement->bindParam(':cartID', $cartID);
            $statement->bindParam(':productID', $productID);
            $statement->bindParam(':quantity', $quantity);

            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteCartItem(int $cartItemID): PDOStatement|string
    {
        try {
            $deleteCartItemQuery = 'DELETE FROM cartItems WHERE id = :cartItemID';
            $statement = $this->dbConnection->prepare($deleteCartItemQuery);
            $statement->bindParam(':cartItemID', $cartItemID);

            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
    
    public function deleteAllCartItems(int $cartID): PDOStatement|string
    {
        try {
            $deleteCartItemsQuery = 'DELETE FROM cartItems WHERE cartID = :cartID';
            $cartItemsStatement = $this->dbConnection->prepare($deleteCartItemsQuery);
            $cartItemsStatement->bindParam(':cartID', $cartID);

            return $cartItemsStatement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
