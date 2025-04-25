<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Model\CartModel;
use Lattefront\FormHandeling\FactoryDesign\ProductFactory;
use Lattefront\FormHandeling\Model\OrderItems;
use Lattefront\FormHandeling\Model\OrderModel;
use Lattefront\FormHandeling\Model\Product;

class OrderController extends Controller
{
    private CartModel $cartModel;
    private OrderModel $orderModel;
    private OrderItems $orderItems;
    private Product $product;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->orderItems = new OrderItems();
        $this->product = new Product();
    }
    public function checkoutform(): int
    {
        $cartItems = $this->cartModel->viewCart();

        $paymentTypes = [];
        $totalPrice = 0;



        foreach ($cartItems as $item) {
            $productTypes = ProductFactory::createTypes($item); // PhysicalProduct or DigitalProduct
            $totalPrice += $productTypes->getDiscountedPrice();
            $paymentTypes = array_unique(array_merge($paymentTypes, $productTypes->getPaymentMethod()));
        }

        // check if cartitems has both types of products, if yes then remove COD from $paymentMethods
        $productTypes = array_unique(array_column($cartItems, "productTypes"));
        if (in_array("digital", $productTypes) && in_array("physical", $productTypes)) {
            $paymentTypes = array_filter($paymentTypes, function ($paymentType) {
                return $paymentType !== "COD";
            });
        }

        require __DIR__ . '/../View/checkout.php';
        return $totalPrice;
    }

    public function checkout(): void
    {
        $cartItems = $this->cartModel->viewCart();

        $address = strip_tags($_POST['address']);
        $payment = strip_tags($_POST['payment']);
        $status = "Pending";
        $totalprice = $this->checkoutform();
        $tax = $totalprice * 13 / 100;

        $totalprice += $tax; //total after tax


        $cartId = $this->session->getCartId();

        $orderId = $this->orderModel->CreateOrder($cartId, $address, $status, $payment, $tax, $totalprice);
        foreach ($cartItems as $item) {
            $unitPrice = $item['price'];
            $quantity = $item['quantity'];
            $productID = $item['productID'];
            $this->orderItems->AddOrderItems($orderId, $productID, $quantity, $unitPrice);

            $this->product->reduceproductquantity($quantity, $productID);
        }
        //deleting cart items after order
        $this->cartModel->removeCart($cartId);
        header("Location: /viewcart");
    }
}
