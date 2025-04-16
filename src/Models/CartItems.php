<?php

namespace ECommerce\Models;

use ECommerce\Models\Cart;
use ECommerce\Services\DatabaseConnection;
use PDO;

final class CartItems
{
    private $dbConnection;
    private $cartModel;
    public function __construct()
    {
        $this->dbConnection = DatabaseConnection::getInstance();
        $this->cartModel = new Cart();
    }

    public function getCartItem($cartID, $productID)
    {
        try {
            $query = 'SELECT * FROM cartItems WHERE `cartID` = :cartID AND `productID` = :productID';
            $statement = $this->dbConnection->prepare($query);
            $statement->bindParam(':cartID', $cartID);
            $statement->bindParam(':productID', $productID);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

    public function checkProductStock($id, $quantity)
    {
        try {
            $checkQuantityQuery = 'SELECT quantity FROM products WHERE id = :id';
            $statement = $this->dbConnection->prepare($checkQuantityQuery);
            $statement->bindParam(':id', $id);
            $statement->execute();
            $productStock = $statement->fetch(PDO::FETCH_ASSOC);
            if ($productStock['quantity'] < $quantity) return false;
            return true;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateProductQuantity($quantity, $id)
    {
        try {
            $updateQuery = 'UPDATE `cartItems` SET `quantity` = :quantity WHERE `id` = :id';
            $statement = $this->dbConnection->prepare($updateQuery);
            $statement->bindParam(':quantity', $quantity);
            $statement->bindParam(':id', $id);
            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function addItemToCart($userID, $productID, $quantity = 1)
    {
        try {
            $cart = $this->cartModel->getCartByUserID($userID);
            if (!$cart) {
                $this->cartModel->createUserCart($userID);
                $cart = $this->cartModel->getCartByUserID($userID);
            }
            $cartID = $cart['id'];
            $existingItem = $this->getCartItem($cartID, $productID);
            $id = $existingItem['id'];

            if ($existingItem) {
                $updationResult = $this->updateProductQuantity($quantity, $id);
                return $updationResult;
            } else {
                $insertQuery = 'INSERT INTO `cartItems` (`cartID`, `productID`, `quantity`, `price`) 
                            VALUES (:cartID, :productID, :quantity, (
                                SELECT `price` FROM `products` WHERE `id` = :productID
                            ))';
                $statement = $this->dbConnection->prepare($insertQuery);
                $statement->bindParam(':cartID', $cartID);
                $statement->bindParam(':productID', $productID);
                $statement->bindParam(':quantity', $quantity);
                return $statement->execute();
            }
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCartItems($userID)
    {
        try {
            $getCartItemsQuery = 'SELECT 
                                cartItems.id,
                                products.name, 
                                products.price, 
                                cartItems.quantity, 
                                (products.price * cartItems.quantity) AS totalPrice
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

    public function deleteCartItem($cartItemID)
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
}
