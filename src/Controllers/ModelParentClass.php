<?php

namespace ECommerce\Controllers;

use ECommerce\Models\Cart;
use ECommerce\Models\CartItems;
use ECommerce\Models\Order;
use ECommerce\Models\OrderItems;
use ECommerce\Models\Product;
use ECommerce\Models\User;
use ECommerce\Services\Session;

class ModelParentClass
{
    protected $cartItems;
    protected $cart;
    protected $order;
    protected $orderItems;
    protected $product;
    protected $user;
    protected $session;

    public function __construct()
    {
        $this->cartItems = new CartItems();
        $this->cart = new Cart();
        $this->order = new Order();
        $this->orderItems = new OrderItems();
        $this->product = new Product();
        $this->user = new User();
        $this->session = Session::getInstance();
    }
}
