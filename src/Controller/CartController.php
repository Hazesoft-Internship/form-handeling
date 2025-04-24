<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Model\CartModel;
use Lattefront\FormHandeling\Session\Session;
use Lattefront\FormHandeling\Model\Product;

class CartController extends Controller
{

    private CartModel $cartModel;
    private Product $product;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();//new DbConnection(), $this->session
        $this->product = new Product();
    }
    public  function addproductCart(): void
    {

        $productId = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $productName = strip_tags($_POST['name']);
        $productPrice = filter_var($_POST['price'], FILTER_VALIDATE_INT);
        $productDescription = strip_tags($_POST['description']);
        $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);

        // print_r($productId);
        $stock = $this->product->getproductdetails($productId);
        $this->cartModel->addProduct($productId, $quantity, $productName, $productDescription, $stock[0]);

        header("Refresh:1; url=/viewallproducts");
    }
    public function updatecartpage(): void
    {
        $productId = filter_var($_GET['productID'], FILTER_VALIDATE_INT);
        $quantity = strip_tags($_GET['quantity']);
        $cart_itemsId = filter_var($_GET['cartitemsId'], FILTER_VALIDATE_INT);


        require __DIR__ . '/../View/updatecart.php';
    }
    public function updateCart(): void
    {

        $productId = filter_var($_POST['productID'],FILTER_VALIDATE_INT);
        $quantity = strip_tags($_POST['quantity']);
        $cart_itemsId = filter_var($_POST['cartitemsId'],FILTER_VALIDATE_INT);
      
        $maxquantity = $this->product->getproductdetails($productId);
        // print_r($maxquantity);

        $this->cartModel->updateCart($productId, $quantity, $cart_itemsId, $maxquantity[0]);
        header("Refresh:2; url=/viewcart");
    }
    public function viewcart(): void
    {
        $cartItems = $this->cartModel->viewCart();
        // Calculate total price
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        //  print_r($cartItems);
        require __DIR__ . '/../View/cart.php';
    }
    public function removecartproduct(): void
    {
        $productId = filter_var($_POST['productID'],FILTER_VALIDATE_INT);
        $this->cartModel->removeProduct($productId);
        header("Location: /viewcart");
    }
}
