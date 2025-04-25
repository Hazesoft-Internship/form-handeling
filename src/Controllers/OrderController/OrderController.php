<?php

namespace Hazesoft\Backend\Controllers\OrderController;

use Exception;
use Hazesoft\Backend\Models\CartItems;
use Hazesoft\Backend\Models\User;
use Hazesoft\Backend\Services\Session;
use Hazesoft\Backend\Models\Carts;
use Hazesoft\Backend\Models\Order;
use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Factories\ProductFactory;
use Hazesoft\Backend\Factories\PaymentMethodFactory;

class OrderController
{
    private $user;
    private $session;
    private $cartItems;
    private $carts;
    private $order;
    private $product;
    private $physicalProduct;
    private $digitalProduct;
    private $paymentMethodFactory;

    public function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
        $this->cartItems = new CartItems();
        $this->carts = new Carts();
        $this->order = new Order();
        $this->product = new Product();
        $this->physicalProduct = ProductFactory::createProductByType("physical");
        $this->digitalProduct = ProductFactory::createProductByType("digital");
        $this->paymentMethodFactory = new PaymentMethodFactory();
    }
    public function getCheckoutPage()
    {
        $userId = $this->session->getSession("userId");

        $viewData = $this->handleCheckoutData();
        extract($viewData);
        return require_once(__DIR__ . '/../../Views/order-checkout.php');
    }

    public function handleCheckoutData()
    {
        [$cartItems, $totalPrice] = $this->handleCartDetailsData();

        $userId = $this->session->getSession("userId");
        $address = $this->user->getUserAddress($userId);

        $productTypes = $this->cartItems->getProductType($userId);

        // get payment methods
        $paymentMethods = $this->paymentMethodFactory->getPaymentMethods($productTypes);

        // calculate price after shipping cost and discount
        $totalPrice = $this->physicalProduct->addShippingCost($cartItems, $totalPrice);
        $totalPrice = $this->digitalProduct->applyDiscount($cartItems, $totalPrice);

        return [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'address' => $address,
            'paymentMethods' => $paymentMethods
        ];
    }

    public function handleCartDetailsData()
    {
        try {
            $userId = $this->session->getSession("userId");

            $cartItems = $this->cartItems->getCartItems($userId);

            $totalPrice = array_reduce($cartItems, [$this, 'addPrice'], 0);

            return [$cartItems, $totalPrice];

        } catch (Exception $exception) {
            echo ("Error: " . $exception->getMessage());
        }
    }

    public function addPrice($carry, $item)
    {
        return ($carry + ($item["item_grand_total"]));
    }

    public function handleCheckoutForm(){
        try{
            if (!isset($_POST['orderSubmit'])) {
                echo ("Error processing checkout");
                exit;
            }
            
            $checkoutData = $this->handleCheckoutData();
            // extract($checkoutData);
            
            $cartItems = $checkoutData["cartItems"];
            $address = $checkoutData["address"];

            // This is total before tax but after shipping cost and discounts
            $subTotalBeforeTax = $checkoutData["totalPrice"];

            $userId = $this->session->getSession("userId");

            $totalTaxAmountForOrders = $this->calculateTax($cartItems);

            // foreach($cartItems as $item){
            //     $taxAmount = ($item["product_tax"] * $item["product_price"] * $item["added_quantity"]) / 100;
            //     $totalTaxAmountForOrders += $taxAmount;
            //     $totalAmountForOrders += $item["item_grand_total"];
            // }

            // Price including tax, discount and shipping charge
            $totalAmountForOrders = $totalTaxAmountForOrders + $subTotalBeforeTax;

            // for Orders table
            $cartId = $this->carts->getCartId($userId);
            $status = "pending"; // default status for now
            $paymentType = $_POST["paymentType"];

            // for orders data insertion
            $ordersArray = [$cartId, $address, $status, $paymentType, $totalTaxAmountForOrders, $totalAmountForOrders];
            $this->order->insertOrders($ordersArray);
            $this->insertOrderItems($cartItems);
            
            // update product quantity and remove cartItems after checkout
            $this->handleAfterCheckout($cartItems, $userId);

            // order placed message
            echo("Order placed successfully");       

            echo"
            <br>
                <a href='/products'>Go to products page</a>
            ";

        } catch(Exception $exception){
            echo($exception->getMessage());
        }
    }

    public function calculateTax($cartItems){
        $totalTaxAmountForOrders = 0;
        foreach($cartItems as $item){
            $taxPercent = $item["product_tax"];
            $price = $item["product_price"];
            $quantity = $item["added_quantity"];
            $taxAmount = ($taxPercent * $price * $quantity) / 100;
            $totalTaxAmountForOrders += $taxAmount;
        }
        return $totalTaxAmountForOrders;
    }

    public function insertOrderItems($cartItems)
    {
        // for order_items data insertion 
        $userId = $this->session->getSession("userId");
        $cartId = $this->carts->getCartId($userId);
        $orderId = $this->order->getOrderId($cartId);
        foreach ($cartItems as $item) {
            $orderItemsArray = [
                $orderId,
                $item["product_id"],
                $item["added_quantity"],
                $item["product_price"],
                $item["item_grand_total"]
            ];

            $this->order->insertOrderItems($orderItemsArray);
        }
    }
    
    // update product quantity and remove cartItems after checkout
    public function handleAfterCheckout($cartItems, $userId){
        try {
            foreach ($cartItems as $item) {
                $productId = $item["product_id"];
                $orderedQuantity = $item["added_quantity"];

                // product quantity deducted after checkout
                $this->product->decreaseProductQuantity($productId, $orderedQuantity);

                // cartItems removed after checkout
                $this->cartItems->deleteCartItem($productId, $userId);
            }
        } catch (Exception $exception) {
            echo ($exception->getMessage());
        }
    }
}

