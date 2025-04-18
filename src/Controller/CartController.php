<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Model\CartModel;
use Lattefront\FormHandeling\Session\Session;
use Lattefront\FormHandeling\Model\Product;

class CartController
{
    private Session $session;
    private CartModel $cartModel;

    public function __construct()
    {
        $this->session = Session::getInstance(); // Initialize the session instance
        $this->cartModel = new CartModel(new DbConnection(), $this->session);
    }
    public  function addproductCart()
    {

        $productId = $_POST['id'];
        $productName = $_POST['name'];
        $productPrice = $_POST['price'];
        $productDescription = $_POST['description'];
        $quantity = $_POST['quantity'];

        // print_r($productId);

        $this->cartModel->addProduct($productId, $quantity, $productName, $productPrice, $productDescription);

        header("Refresh:1; url=/viewallproducts");
    }
    public function updatecartpage()
    {
        $productId = $_GET['productID'];
        $quantity = $_GET['quantity'];
        $cart_itemsId = $_GET['cartitemsId'];


        require __DIR__ . '/../View/updatecart.php';
    }
    public function updateCart()
    {

        $productId = $_POST['productID'];
        $quantity = $_POST['quantity'];
        $cart_itemsId = $_POST['cartitemsId'];

        $prodquantity = new Product(new DbConnection());
        $maxquantity = $prodquantity->getproductquantity($productId);


        $this->cartModel->updateCart($productId, $quantity, $cart_itemsId, $maxquantity);
        header("Refresh:2; url=/viewcart");
    }
    public function viewcart()
    {
        $cartItems = $this->cartModel->viewCart();

        require __DIR__ . '/../View/cart.php';
    }
    public function removecartproduct()
    {
        $productId = $_POST['productID'];
        $this->cartModel->removeProduct($productId);
        header("Location: /viewcart");
    }
}
