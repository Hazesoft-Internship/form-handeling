<?php 

namespace App\controller;
require_once __DIR__. "/../../vendor/autoload.php";

use App\Model\Database;
use App\Model\Cart;
use App\session\session;

class CartController
{
    private $cart1;
    public function __construct()
    {
        $this->cart1 = new Cart();
    }
    public function showYourCart(): int
    {
        $userID = Session::getInstance()->get('userID');
        $data = $this->cart1->showCarts($userID);
        return require_once __DIR__. "/../View/carts/showYourCart.php";
    }

    public function createCart(): int
    {
        $id = $_GET['id'];
        $data = $this->cart1->createCart($id);
        return require_once __DIR__. "/../View/carts/createCart.php";
    }

    public function uploadCart(): void
    {
        $quantity = $_POST['quantity'];
        $userID = session::getInstance()->get("userID");
        $productID = $_GET['id'];
        $this->cart1->uploadCart($productID, $userID);
    }

    public function showUpdateCart(): int
    {
        $cartID = $_GET['cartid'];
        $productID = $_GET["productID"];
        $data = $this->cart1->showUpdateCart($cartID, $productID);
        return require_once __DIR__. "/../View/carts/updateCart.php";
    }

    public function updateCart(): void
    {
        $cartID = $_GET['cartID'];
        $productID = $_GET['productID'];
        $updatedQuantity = $_POST["updatedQuantity"];
        $this->cart1->updateCart($cartID, $updatedQuantity, $productID);
    }

    public function deleteCart(): void
    {
        $id = $_GET['id'];
        $this->cart1->deleteCart($id);
    }
}
