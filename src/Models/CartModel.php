<?php

namespace App\Models;

use App\Config\DataBase;
use Exception;
use PDO;
use PDOException;

class CartModel
{

    public object $connection;
    public function __construct()
    {
        $this->connection = DataBase::connect();
    }



    public function isProductInCart(int $product_id)
    {
        try {
            $ifProductExistQuery = "SELECT * FROM cart_items WHERE product_id=? ";
            $statement = $this->connection->prepare($ifProductExistQuery);
            $statement->bindParam(1, $product_id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($result == false) {
                return false;
            }
            return true;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }
    public function getCartIdByUserId(int $userId): int|bool
    {
        try {
            $sql = "SELECT cart_id FROM carts WHERE user_id = ?";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $userId, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result == false) {
                return false;
            }
            return $result['cart_id'];
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function createCart(int $userId): bool
    {
        try {
            $sql = "INSERT INTO carts (user_id)  VALUES (?)";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $userId, PDO::PARAM_INT);

            if ($statement->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function getUserCartItems(int $cartId): array|null
    {
        try {


            $getCartItemQuery = "SELECT  p.name, p.price, p.quantity AS product_quantity, c.id, c.quantity AS cart_quantity  FROM cart_items AS c JOIN products AS p  ON p.product_id= c.product_id  WHERE c.cart_id = ?";
            $statement = $this->connection->prepare($getCartItemQuery);
            $statement->bindParam(1, $cartId, PDO::PARAM_INT);

            if ($statement->execute()) {

                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }

            return null;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return null;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return null;
        }
    }

    public function insertToCart(int $cart_id, int $product_id): bool
    {
        try {

            $insertToCartQuery = "INSERT INTO cart_items (cart_id,product_id) VALUES(
            ?,?)";
            $statement = $this->connection->prepare($insertToCartQuery);
            $statement->bindParam(1, $cart_id, PDO::PARAM_INT);
            $statement->bindParam(2, $product_id, PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function removeItem(int $id): bool
    {
        try {
            $sql = "DELETE FROM cart_items WHERE id=?";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $id);
            if ($statement->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function updateCart(int $cart_item_id, int $updatedQuantity)
    {
        try {
            $updateCartQuery = "UPDATE  cart_items SET quantity=? WHERE id=?";
            $statement = $this->connection->prepare($updateCartQuery);
            $statement->bindParam(1, $updatedQuantity, PDO::PARAM_INT);
            $statement->bindParam(2, $cart_item_id, PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }
    public function emptyCart(int $user_id): bool
    {
        try {
            $sql = "DELETE * FROM cart_items WHERE user_id:user_id";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $user_id, PDO::PARAM_INT);
            if ($statement->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }
}
