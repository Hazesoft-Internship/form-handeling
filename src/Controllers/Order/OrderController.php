<?php

namespace App\Controllers\Order;

use App\Config\DataBase;
use App\Models\Order\OrderItemModel;
use App\Models\Order\OrderModel;
use App\Sessions\Sessions;
use App\Controllers\Cart\CartController;
use App\Controllers\Controller;
use App\Models\Cart\CartModel;
use App\Models\Product\PhysicalProduct;
use App\Models\Product\ProductModel;

class OrderController extends Controller
{

    public $cart;
    public $order;
    public $orderItem;
    public $product;
    public $connection;
    public CartModel $cartModel;

    public function __construct()
    {
        parent::__construct();
        $this->connection = DataBase::connect();
        $this->cart = new CartController();
        $this->order = new OrderModel();
        $this->cartModel = new CartModel();
        $this->orderItem = new OrderItemModel();
        $this->product = new ProductModel();
    }
    public function checkoutPage()
    {

        $cartItems = $this->cart->viewCart();
        if ($cartItems === null) {
            echo "No items in cart";
            exit();
        }

        $totalOrder = 0;
        $subTotal = 0;
        foreach ($cartItems as $item) {

            $subTotal = $item['price'] * $item['cart_quantity'];
            $totalOrder += $subTotal;
        }

        $payment_method = $this->getPaymentMethod();
        $discount = $totalOrder * ($this->getDiscount() / 100);
        $shipping = $this->getShipping();
        $tax = $this->calculateTax($totalOrder);
        $grandTotal = $this->calculateTotal($totalOrder);


        require __DIR__ . "/../../Views/checkout.php";
    }

    public function createOrder()
    {
        if (!isset($_POST['address']) ||  !isset($_POST['payment'])) {
            echo "unable to create order";
        }
        $address = $_POST['address'];
        $payment_method = $_POST['payment'];
        $cart_id = $this->cart->getCartId();
        $cartItems = $this->cart->viewCart($cart_id);

        $user_id = $this->session->getSession('user')['user_id'];
        $totalOrder = 0;
        $subTotal = 0;
        foreach ($cartItems as $item) {

            $subTotal = $item['price'] * $item['cart_quantity'];
            $totalOrder += $subTotal;
        }
        $discount = $totalOrder * ($this->getDiscount() / 100);
        $shipping = $this->getShipping();
        $tax = $this->calculateTax($totalOrder);
        $grandTotal = $this->calculateTotal($totalOrder);

        $data = $this->order->insertOrder($address, $payment_method, $user_id, $shipping, $discount, $tax, $grandTotal);

        $orderId = $this->connection->LastInsertId();

        foreach ($cartItems as $item) {

            $this->orderItem->insertOrderItem($item['product_id'], $orderId, $item['price'], $item['cart_quantity']);
            $this->product->reduceQuantity($item['product_id'], $item['cart_quantity']);
            $this->cartModel->emptyCart($cart_id);
        }
        
    }

    protected function countPhysicalDigitalProduct(): array|null
    {

        $cart_id = $this->cart->getCartId();
        $cartItems = $this->cart->viewCart($cart_id);

        if ($cartItems == null) {
            die("cart Item not found");
        }


        $physicalProduct = 0;
        $digitalProduct = 0;
        $totalProduct = 0;

        foreach ($cartItems as $item) {

            if ($item['type'] == 'physical') {
                $physicalProduct++;
            }

            if ($item['type'] == 'digital') {
                $digitalProduct++;
            }
            $totalProduct++;
        }

        return ['physical' => $physicalProduct, 'digital' => $digitalProduct, 'total' => $totalProduct];
    }

    protected function getPaymentMethod()
    {
        $payment_method = [];

        $count = $this->countPhysicalDigitalProduct();


        if ($count['physical'] > 0 && $count['digital'] > 0) {
            array_push($payment_method, "esewa", "khalti");
            return $payment_method;
        }

        if ($count['physical'] == 0) {
            array_push($payment_method, "khalti");
            return $payment_method;
        }

        if ($count['digital'] == 0) {
            array_push($payment_method, "esewa", "khalti", "cash on delivery");
            return $payment_method;
        }
    }

    protected function getOrderQuantity()
    {
        $cart_id = $this->cart->getCartId();
        $cartItems = $this->cart->viewCart($cart_id);

        $physicalProductQuantity = 0;
        $digitalProductQuantity = 0;
        $totalQuantity = 0;

        foreach ($cartItems as $item) {

            if ($item['type'] == 'physical') {
                $physicalProductQuantity += $item['cart_quantity'];
            }

            if ($item['type'] == 'digital') {
                $digitalProductQuantity += $item['cart_quantity'];
            }
            $totalQuantity++;
        }

        return ['physical' => $physicalProductQuantity, 'digital' => $digitalProductQuantity, 'total' => $totalQuantity];
    }

    protected function getDiscount(): int
    {
        $orderQuantity = $this->getOrderQuantity();



        if ($orderQuantity['digital'] >= 6 && $orderQuantity['digital'] < 12) {

            return 10;
        }

        if ($orderQuantity['digital'] >= 12) {

            return 20;
        }

        return 0;
    }

    protected function getShipping(): int
    {
        $orderQuantity = $this->getOrderQuantity();

        if ($orderQuantity['physical'] >= 5 && $orderQuantity['physical'] < 10) {
            return 100;
        }
        if ($orderQuantity['physical'] >= 10) {
            return 200;
        }

        return 0;
    }

    protected function calculateTax(float $total): float
    {
        return $total * (13 / 100);
    }

    protected function calculateTotal(float $order)
    {
        return $order + $this->getShipping() + $this->calculateTax($order) - $this->getDiscount();
    }
}
