<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Model\CartModel;
use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\FactoryDesign\ProductFactory;
use Lattefront\FormHandeling\Model\Digitalproduct;
use Lattefront\FormHandeling\Model\OrderItems;
use Lattefront\FormHandeling\Model\OrderModel;
use Lattefront\FormHandeling\Session\Session;
use Lattefront\FormHandeling\Model\Physicalproduct;
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
        $physicalPrice = 0;
        $digitalPrice = 0;
        $physicalquantity = 0;
        $digitalquantity = 0;



        foreach ($cartItems as $item) {
            match ($item['productTypes']) {
                "physical" => [
                    $physicalPrice += $item['price'] * $item['quantity'],
                    $physicalquantity += $item['quantity']
                ],
                "digital" => [
                    $digitalPrice += $item['price'] * $item['quantity'],
                    $digitalquantity += $item['quantity']
                ]
            };
        }
        $totalData = [
            "digital" => [
                "totalPrice" => $digitalPrice,
                "totalQuantity" => $digitalquantity,
            ],
            "physical" => [
                "totalPrice" => $physicalPrice,
                "totalQuantity" => $physicalquantity,
            ],
        ];

        $types = array_unique(array_column($cartItems, "productTypes"));
        $totalPrice = 0;
        foreach ($types as $item) {
            $type = $totalData[$item];
            $productTypes = ProductFactory::createTypes($item);
            $paymentTypes = $productTypes::getPaymentMethod();

            $totalPrice += $productTypes->getDiscountedPrice($type["totalQuantity"], $type["totalPrice"]);
        }

       
        if (in_array("digital", $types) && (in_array("physical", $types))) {
            $paymentTypes = ["Esewa", "Khalti"];
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
