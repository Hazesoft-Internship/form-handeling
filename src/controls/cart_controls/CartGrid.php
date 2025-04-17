<?php

namespace ayushtamang\FormHandeling\controls\cart_controls;

use \ayushtamang\FormHandeling\session\Session;
use \ayushtamang\FormHandeling\database\Database;

class CartGrid
{
    private $session;
    public function __construct(private $con) 
    {
        $db = Database::getInstance();
        $this->con = $db->getConnection();
        $this->session = Session::getInstance();
    }

    public function getCartId($userId)
    {
        $query = $this->con->prepare("SELECT id FROM carts WHERE userId = :ui");
        $query->bindParam(":ui", $userId);
        $query->execute();
        
        return $query->fetch();
    }

    public function getCart()
    {
        $cartId = $this->getCartId($this->session->getSession("userId"));
        $cartId = $cartId["id"] ?? null;
        $query = $this->con->prepare("SELECT * FROM cartItems AS ci JOIN products AS p ON p.id = ci.productId  WHERE cartId = :ci");
        $query->bindParam(":ci", $cartId);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getCartsOfUser(): string
    {
        $cartItems = $this->getCart();
        $elementHTML = "";

        foreach ($cartItems as $item) {
            $elementHTML .= "<div>
                                <label>Product Name: </label>
                                {$item['productName']}
                                <label>Quantity: </label>
                                {$item['quantity']}
                                <label>Price: </label>
                                {$item['price']}
                                <br>
                                <a href='/tempo/php/Form/form-handeling/public/product/cart/update?id={$item['id']}' style='text-decoration: none;'>
                                    <input type='submit' name='Update' value='Update'>
                                </a>
                                <a href='#'>
                                    <input type='submit' name='CheckOut' value='CheckOut'>
                                </a>
                            </div>";
        }

        if (empty($elementHTML)) {
            $elementHTML = "<span>No! carts to show.</span><br>";
        }

        return "<div>
                    <h1>Cart Item</h1>
                    $elementHTML
                    <a href='/tempo/php/Form/form-handeling/public/product'>Back</a>
                </div>";
    }

    public function getSingleCart($id)
    {
        $query = $this->con->prepare("SELECT ci.quantity, ci.price, p.productName, p.productQuantity 
                                            FROM cartItems AS ci INNER JOIN products AS p 
                                            ON p.id = ci.productId  WHERE productId = :pi");
        $query->bindParam(":pi", $id);
        $query->execute();

        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getCartUpdateForm()
    {
        $id = $_GET["id"] ?? null;
        $cartItem = $this->getSingleCart($id);
        $productName = $cartItem["productName"];
        $productQuantity = $cartItem["productQuantity"];
        $price = $cartItem["price"];
        $quantity = $cartItem["quantity"];

        return "<h1>Update Cart Item</h1>
                <form onsubmit='onUpdate(event)' method='POST' action='/tempo/php/Form/form-handeling/public/product/cart/updateSubmit?id=$id'>
                    <label>Product Name: </label>
                    $productName
                    <br>
                    <label>Product Price: </label>
                    $price
                    <br>
                    <label>Product Quantity: </label>
                    <input type='number' name='quantity' min='1' max='$productQuantity' value='$quantity'>
                    <br>
                    <input type='submit' name='updateCart' value='Update'>
                </form>
                <form onsubmit='onDelete(event)' method='POST' action='/tempo/php/Form/form-handeling/public/product/cart/deleteSubmit?id=$id'>
                    <input type='submit' name='deleteCart' value='Delete'>
                </form>
                <a href='/tempo/php/Form/form-handeling/public/product/cart'>Back</a>";
    }

}
?>