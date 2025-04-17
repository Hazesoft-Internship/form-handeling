<?php

namespace ayushtamang\FormHandeling\model;

use ayushtamang\FormHandeling\controls\Validation;
use ayushtamang\FormHandeling\session\Session;
use COM;

class CartItems extends Validation
{
    private $session;

    public function __construct(private $con)
    {
        $this->con = $con;
        $this->session = Session::getInstance();
    }

    public function getCartId()
    {
        $userId = $this->session->getSession("userId");

        $query = $this->con->prepare("SELECT id FROM carts WHERE userId = :ui");
        $query->bindParam(":ui", $userId);
        $query->execute();
        $id = $query->fetch(\PDO::FETCH_ASSOC);

        return $id["id"] ?? null;
    }

    public function insertCartItem($cartId, $productId, $quantity, $price)
    {
        try {
            $query = $this->con->prepare("INSERT INTO cartItems (cartId, productId, quantity, price) VALUES (:ci, :pi, :q, :p)");
            $query->bindParam(":ci", $cartId);
            $query->bindParam(":pi", $productId);
            $query->bindParam(":q", $quantity);
            $query->bindParam(":p", $price);
            return $query->execute();
        } catch (\PDOException) {
            throw new \PDOException("InsertCartItem failed!");
        }
    }

    public function addCartItem($productId, $quantity, $price)
    {
        try {
            $cartId = $this->getCartId();
            $cart = new Cart($this->con);
            $this->validateNumber($quantity, "Quantity");
            $this->validateNumber($price, "Price");

            $productId = $_GET["id"] ?? null;
            $product = new GetProductDetails($this->con, $productId);
            $productQuantity = $product->getProductQuantity();

            if ($productQuantity < $quantity) {
                throw new \PDOException("Product quantity is not available!");
            }

            if (empty($cartId)) {
                $cart->addCart($this->session->getSession("userId"));
                return $this->insertCartItem($cartId, $productId, $quantity, $price);
            }

            return $this->insertCartItem($cartId, $productId, $quantity, $price);
        } catch (\PDOException $e) {
            throw new \PDOException("AddCartItem failed: " . $e->getMessage());
        }
    }

    public function updateCartItem($productId, $quantity, $price)
    {
        try {
            $this->validateNumber($price, "Price");
            $this->validateNumber($quantity, "Quantity");

            $productId = $_GET["id"] ?? null;
            $product = new GetProductDetails($this->con, $productId);
            $productQuantity = $product->getProductQuantity();

            if ($productQuantity < $quantity) {
                throw new \PDOException("Product quantity is not available!");
            }

            $query = $this->con->prepare("UPDATE cartItems SET quantity = :q, price = :p WHERE productId = :pi");
            $query->bindParam(":q", $quantity);
            $query->bindParam(":p", $price);
            $query->bindParam(":pi", $productId);
            return $query->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("UpdateCartItem failed: " . $e->getMessage());
        }
    }

    public function deleteCartItem($productId)
    {
        try {
            $query = $this->con->prepare("DELETE FROM cartItems WHERE productId = :pi");
            $query->bindParam(":pi", $productId);
            return $query->execute();
        } catch (\PDOException) {
            throw new \PDOException("DeleteCartItem failed!");
        }
    }
}
?>