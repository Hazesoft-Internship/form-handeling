<?php

namespace App\Controllers\Order;

use App\Config\DataBase;
use App\Models\Order\OrderItemModel;
use App\Models\Order\OrderModel;
use App\Controllers\Cart\CartController;
use App\Controllers\Controller;
use App\Factory\ProductFactory;
use App\Models\Cart\CartModel;
use App\Models\Product\ProductModel;

class OrderController extends Controller
{

    public $cart;
    public $order;
    public $orderItem;
    public $product;
    public $connection;
    public CartModel $cartModel;
    public array $orderDetail = [];

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
        $cart_id = $this->cart->getCartId();
        $cartItems = $this->cart->viewCart($cart_id);


        if ($cartItems == null) {
            echo "Noting in cart";
            echo "<a href='/'>Home</a>";
            die();
        }

        $factory = new productFactory();
        $payment_method = [];
        $types = [];

        $discount = 0;
        $shipping = 0;

        $totalOrder = 0;
        $totalDiscount = 0;
        $totalShipping = 0;
        $grandTotal = 0;

        $newCartItems = [];
        foreach ($cartItems as $item) {
            $product = $factory->createProduct($item['type']);
            $types = array_unique(array_merge($types, [$item['type']]));

            $discount = $this->calculateDiscount($item['price'], $item['cart_quantity'], $product->getDisount($item['cart_quantity']));

            $shipping = $product->getShippingCharge($item['cart_quantity']);
            $payment_method = array_unique(array_merge($payment_method, $product->getPaymentMethod()));
            $total = $item['price'] * $item['cart_quantity'] + $shipping - $discount;


            $totalOrder += $total;
            $totalShipping += $shipping;
            $totalDiscount += $discount;
            $grandTotal += $total;

            $newCartItems = [...$newCartItems, [...$item, 'discount' => $discount, 'shipping' => $shipping]];
        }



        $tax = $this->calculateTax($grandTotal);



        if (in_array("digital", $types) && in_array("physical", $types)) {
            $payment_method = array_filter($payment_method, function ($key) {
                return $key !== "cash on delivery";
            });
        }

        $this->orderDetail = ['discount' => $totalDiscount, 'shipping' => $totalShipping, 'tax' => $tax, 'grandTotal' => $grandTotal + $tax, 'total' => $totalOrder];



        require __DIR__ . "/../../Views/checkout.php";
    }


    public function handleCheckout()
    {

        $cart_id = $this->cart->getCartId();
        $cartItems = $this->cart->viewCart($cart_id);


        $cartItems = $this->cart->viewCart();
        if ($cartItems === null) {
            echo "No items in cart";
            exit();
        }

        $factory = new productFactory();
        
        $discount = 0;
        $shipping = 0;

        $totalOrder = 0;
        $totalDiscount = 0;
        $totalShipping = 0;
        $grandTotal = 0;

        foreach ($cartItems as $item) {
            $product = $factory->createProduct($item['type']);

            $discount = $this->calculateDiscount(
                $item['price'],
                $item['cart_quantity'],
                $product->getDisount($item['cart_quantity'])
            );
            $shipping = $product->getShippingCharge($item['cart_quantity']);
            $payment_method = $product->getPaymentMethod();
            $total = $item['price'] * $item['cart_quantity'] + $shipping - $discount;


            $totalOrder += $total;
            $totalShipping += $shipping;
            $totalDiscount += $discount;
            $grandTotal += $total;
        }

        $tax = $this->calculateTax($grandTotal);


        $this->orderDetail = ['discount' => $totalDiscount, 'shipping' => $totalShipping, 'tax' => $tax, 'grandTotal' => $grandTotal + $tax, 'total' => $totalOrder];
    }
    public function createOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            die("checkout from cart");
        }
        if (!isset($_POST['address']) ||  !isset($_POST['payment'])) {
            echo "unable to create order";
        }
        $address = $_POST['address'];
        $payment_method = $_POST['payment'];

        $cart_id = $this->cart->getCartId();
        $cartItems = $this->cart->viewCart($cart_id);
        $user_id = $this->session->getSession('user')['user_id'];

        $this->handleCheckout();


        $this->order->insertOrder($address, $payment_method, $user_id, $this->orderDetail['shipping'], $this->orderDetail['discount'], $this->orderDetail['tax'], $this->orderDetail['grandTotal']);

        $orderId = $this->connection->LastInsertId();

        $factory = new ProductFactory();

        foreach ($cartItems as $item) {



            $product = $factory->createProduct($item['type']);

            $discount = $this->calculateDiscount($item['price'], $item['cart_quantity'], $product->getDisount($item['cart_quantity']));
            $shipping = $product->getShippingCharge($item['cart_quantity']);
            $total = $item['price'] * $item['cart_quantity'] + $shipping - $discount;


            $this->orderItem->insertOrderItem($item['product_id'], $orderId, $item['price'], $item['cart_quantity'], $shipping, $discount, $total);

            $this->product->reduceQuantity($item['product_id'], $item['cart_quantity']);
            $this->cartModel->emptyCart($cart_id);
        }
    }


    protected function calculateTax(float $total): float
    {
        return $total * (13 / 100);
    }

    protected function calculateDiscount(float $price, int $quantity, int $discount)
    {
        return ($price * $quantity) * $discount / 100;
    }
}
