<?php
namespace App\controller;
use App\model\Product;
use App\model\User;
use App\database\Database;
use App\model\Cart;
use App\model\CartItem;
use App\session\Session;

class Constructor
{
    protected $productModel;
    protected $userModel;
    protected $cartModel;
    protected $cartItemModel;

    public function __construct()
    {
        $conn = Database::getInstance();
        $db = $conn->getConnection();
        $this->productModel = new Product($db);
        $this->userModel = new User($db);
        $this->cartModel = new Cart($db);
        $this->cartItemModel = new CartItem($db);
    }

    public function getSession($identifier)
    {
        $session = Session::getInstance();
        $userId = $session->getSession($identifier);
        return $userId;
    }
    
}