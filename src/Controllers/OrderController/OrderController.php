<?php

namespace Hazesoft\Backend\Controllers\OrderController;

use Exception;
use Hazesoft\Backend\Models\CartItems;
use Hazesoft\Backend\Models\User;
use Hazesoft\Backend\Services\Session;
use Hazesoft\Backend\Models\Carts;
use Hazesoft\Backend\Models\Order;
use Hazesoft\Backend\Models\Product;

class OrderController
{
    private $user;
    private $session;
    private $cartItems;
    private $carts;
    private $order;
    private $product;

    public function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
        $this->cartItems = new CartItems();
        $this->carts = new Carts();
        $this->order = new Order();
        $this->product = new Product();
    }
    public function getCheckoutPage()
    {
        $userId = $this->session->getSession("userId");
        // insert new row in carts table
        $doesCartExists = $this->carts->doesCartExists($userId);
        
        if ($doesCartExists == false) {
            $result = $this->carts->createCart($userId);
        } else {
            $result = $this->carts->updateCart($userId);
        }

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
        $paymentMethods = $this->getPaymentMethods($productTypes);

        // calculate price after shipping cost and discount
        $totalPrice = $this->applyShippingCostAndDiscount($cartItems, $totalPrice);

        return [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'address' => $address,
            'paymentMethods' => $paymentMethods
        ];
    }

    public function getPaymentMethods($productTypes)
    {
        try {
            $typeArray = [];
            foreach($productTypes as $key => $type){
                $typeArray[] = $type["type"];
            }

            if ((in_array("physical", $typeArray)) && (in_array("digital", $typeArray))) {
                $paymentMethods = ["eSewa", "Khalti"];
            } elseif (in_array("physical", $typeArray)) {
                $paymentMethods = ["Cash on Delivery", "eSewa"];
            } elseif (in_array("digital", $typeArray)) {
                $paymentMethods = ["Khalti"];
            } else {
                $paymentMethods = [];
            }
            return $paymentMethods;

        } catch (Exception $exception) {
            echo ($exception->getMessage());
            return null;
        }
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
            extract($checkoutData);
            
            $userId = $this->session->getSession("userId");

            $taxAndTotalPriceArray = []; // this array contains tax and itemTotalPrice in a array inside it
            $taxAmount = [];

            foreach($cartItems as $item){
                $taxAmount = ($item["product_tax"] * $item["product_price"] * $item["added_quantity"]) / 100;
                $taxAndTotalPriceArray[] = [$taxAmount, $item["item_grand_total"]];
            }

            // for Orders table
            $cartId = $this->carts->getCartId($userId);
            $address = $this->user->getUserAddress($userId);
            $status = "pending"; // default status for now
            $paymentType = $_POST["paymentType"];
            $totalTaxAmountForOrders = 0;
            
            foreach($taxAndTotalPriceArray as $item){
                [$tax, $total] = $item;
                $totalTaxAmountForOrders += $tax;
                $totalAmountForOrders += $total;
                // $this->order->insertOrders($ordersArray);
            }

            // for shipping cost and discount calculation
            $totalAmountForOrders = $this->applyShippingCostAndDiscount($cartItems, $totalAmountForOrders);

            // for orders data insertion
            $ordersArray = [$cartId, $address, $status, $paymentType, $totalTaxAmountForOrders, $totalAmountForOrders];
            $this->order->insertOrders($ordersArray);

            // for order_items data insertion 
            $orderId = $this->order->getOrderId($cartId);
            foreach($cartItems as $item){
                $orderItemsArray = [
                    $orderId,
                    $item["product_id"],
                    $item["added_quantity"],
                    $item["product_price"],
                    $item["item_grand_total"]
                ];

                $this->order->insertOrderItems($orderItemsArray);
            }
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

    public function applyShippingCostAndDiscount($cartItems, $totalPrice){
        try{
            $shippingCost = 0;
            $discountAmount = 0;

            foreach($cartItems as $item){
                switch($item["product_type"]) {
                    case "physical":
                        if(($item["added_quantity"] >= 5) && ($item["added_quantity"]) < 10) {
                            $shippingCost += 100;
                        } elseif($item["added_quantity"] >= 10){
                            $shippingCost += 200;
                        }
                        break;
                    
                    case "digital":
                        if (($item["added_quantity"] >= 6) && ($item["added_quantity"]) < 12) {
                            $discount = ($item["item_grand_total"] * 10) / 100;
                            $discountAmount += $discount;
                        } elseif ($item["added_quantity"] >= 12) {
                            $discount = ($item["item_grand_total"] * 20) / 100;
                            $discountAmount += $discount;
                        }
                        break;
                }
            }
            $totalPrice = $totalPrice - $discountAmount + $shippingCost;
            return $totalPrice;

        } catch (Exception $exception) {
            echo ($exception->getMessage());
        }
    }
}

