<?php

namespace App\Models\Order;


use App\Models\Cart\CartModel;
use App\Models\Model;
use Exception;
use PDO;

class OrderItemModel extends Model
{



    public $cart;

    public function __construct()
    {

        parent::__construct();
        $this->cart = new CartModel();
    }

    public function insertOrderItem(int $product_id, int $order_id, float $price, int $quantity, float $shipping, float $discount, float $total): bool
    {
        try {
            $insertOrderItemQuery = "INSERT INTO order_items (product_id,order_id,price,quantity,shipping,discount,total) VALUES (?,?,?,?,?,?,?)";
            $statment = $this->connection->prepare($insertOrderItemQuery);
            $statment->bindParam(1, $product_id, PDO::PARAM_INT);
            $statment->bindParam(2, $order_id, PDO::PARAM_INT);
            $statment->bindParam(3, $price);
            $statment->bindParam(4, $quantity, PDO::PARAM_INT);
            $statment->bindParam(5, $shipping);
            $statment->bindParam(6, $discount);
            $statment->bindParam(7, $total);



            if ($statment->execute()) {

                // $reduceProductQuantity = "UPDATE products SET quantity=quantity-? WHERE product_id=?";
                // $statment = $this->connection->prepare($reduceProductQuantity);
                // $statment->bindParam(1, $quantity, PDO::PARAM_STR);
                // $statment->bindParam(2, $product_id);

                // if ($statment->execute()) {
                //     $user_id = $this->session->getSession('user')['user_id'];
                //     $cart_id = $this->cart->getCartIdByUserId($user_id);
                //     $emptyCartQuery = "DELETE  FROM cart_items WHERE cart_id=?";
                //     $statment = $this->connection->prepare($emptyCartQuery);
                //     $statment->bindParam(1, $cart_id);
                //     $statment->execute() ??  true;
                // }

                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo "Error:" . $e->getMessage();
            return false;
        }
    }
}
