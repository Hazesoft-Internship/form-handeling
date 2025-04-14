<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\Session;
use Hazesoft\Formhandeling\Models\CartItem;
use Hazesoft\Formhandeling\Services\View;
use Hazesoft\Formhandeling\Services\DateFormatter;

$session = Session::getInstance();

$session->start();


class CartController
{
    use DateFormatter;
    private $productModel;
    private $cartModel;
    private $cartItemModel;
    public $userid;

    public function __construct()
    {
        $this->cartItemModel = new CartItem();
        $this->userid = $_SESSION['id'] ?? null;
    }

    public function viewCart($id)
    {
        $cartItems = $this->cartItemModel->getCartItemsName($id);
        View::render('view_cart', ['cartItems' => $cartItems]);
    }
}
