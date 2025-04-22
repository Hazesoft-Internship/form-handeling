<?php

namespace Hazesoft\Formhandeling\Controllers;

use Hazesoft\Formhandeling\Services\Session;
use Hazesoft\Formhandeling\Models\CartItem;
use Hazesoft\Formhandeling\Models\Cart;
use Hazesoft\Formhandeling\Models\Product;
use Hazesoft\Formhandeling\Services\DateFormatter;
use Hazesoft\Formhandeling\Models\User;
use Hazesoft\Formhandeling\Models\Order;
use Hazesoft\Formhandeling\Models\OrderItems;

$session = Session::getInstance();

$session->start();

class BaseController
{
    use DateFormatter;
    protected $user;
    protected $productModel;
    protected $cartItemModel;
    protected $userid;
    protected $cartModel;
    protected $orderModel;
    protected $orderItemsModel;

    public function __construct()
    {
        $this->user = new User();
        $this->cartItemModel = new CartItem();
        $this->orderItemsModel = new OrderItems();
        $this->productModel = new Product();
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->userid = $_SESSION['id'] ?? null;
    }
}
