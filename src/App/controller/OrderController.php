<?php
namespace App\controller;
use App\controller\Constructor;
use App\model\DigitalProductFactory;
use App\model\PhysicalProductFactory;

class OrderController extends Constructor
{

    public function displayOrderCartProducts()
    {
        $userId = $this->getSession("user_id");
        $cartItems = $this->cartItemModel->getCartItem($userId);
        ["digital"];
        $types = array_unique(array_column($cartItems,"type"));
        $options = [];
        if(count($types)===1 && $types[0]==="digital") {
            $options = ["esewa"];
        } elseif(count($types)===1 && $types[0]==="physical") {
            $options = ["COD", "khalti"];
        } elseif(in_array("digital",$types) && in_array("physical",$types) ) {
            $options = ["esewa", "khalti"];
        }
        include(__DIR__ . "/../view/checkout.php");
    }


    public function displayOrderedProducts() {
        include(__DIR__ . "/../view/order.php");
    }

    public function calculateTotal()
    {
        $userId = $this->getSession("user_id");
        $items = $this->cartItemModel->getCartItem($userId);
        $digitalFactory = new DigitalProductFactory();
        $physicalFactory = new PhysicalProductFactory();
        $total = 0; 

        foreach($items as $item) {
            if($item["type"] === "digital") {
                $product = $digitalFactory->productCreate();
            } else {
                $product = $physicalFactory->productCreate();
            }
            $priceBeforeTax = $product->calculateProduct($item["price"], $item["purchase_quantity"]);
            $priceAfterTax = $priceBeforeTax + ($priceBeforeTax * 0.13);
            $total += $priceAfterTax;
        }
        return $total;
    }

    public function createOrder() 
    {
        $total = $this->calculateTotal();
        $address = $_POST["address"];
        $payment_type = $_POST["paymentMethod"];
        $cartItems = $this->cartItemModel->getCartItem($this->getSession("user_id"));
        $cartId = $this->cartModel->getCart()["id"];
        $orderId = $this->orderModel->createOrder($cartId,$address,$payment_type,$total);
        foreach($cartItems as $cartItem) {
            $this->orderItemModel->createOrderItem($orderId,$cartItem["product_id"],$cartItem["purchase_quantity"],$cartItem["unit_price"], $cartItem["unit_price"] * $cartItem["purchase_quantity"]);
            $this->productModel->reduceStock($cartItem["product_id"],$cartItem["purchase_quantity"]);
            $this->cartItemModel->deleteCartItem($cartItem["cart_item_id"]);
        }
    }
}