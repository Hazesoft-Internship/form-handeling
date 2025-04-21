<?php

namespace Hazesoft\Backend\Controllers\OrderController;

use Exception;
use Hazesoft\Backend\Models\CartItems;
use Hazesoft\Backend\Models\User;
use Hazesoft\Backend\Services\Session;
use Hazesoft\Backend\Models\Carts;
use Hazesoft\Backend\Models\Order;

class OrderController
{
    private $user;
    private $session;
    private $cartItems;
    private $carts;
    private $order;

    public function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
        $this->cartItems = new CartItems();
        $this->carts = new Carts();
        $this->order = new Order();
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
            echo("test");
            if (!isset($_POST['orderSubmit'])) {
                echo ("Error processing checkout");
                exit;
            }
            
            $checkoutData = $this->handleCheckoutData();
            extract($checkoutData);
            
            $ordersArray = [$cartId, $address, $status, $paymentType, $tax, $total];

            // $orderItems = [$orderId, $productId, $quantity, $unitPrice, $totalPriceAfterTax]

            // $isOrderItemsInserted = $this->order->insertOrderItems();

        } catch(Exception $exception){
            echo($exception->getMessage());
        }
    }
}

