<?php

namespace App\model;

use PDO;
use Exception;

class CartItem
{
    public function __construct(private $conn) {}

    public function addToCart($cartId, $productId, $unit_price, $purchase_quantity = 1)
    {
        $stmt = $this->conn->prepare("insert into cart_item (cart_id,product_id,unit_price,purchase_quantity) values (:cartId,:productId,:unit_price,:purchase_quantity) ");
        $stmt->bindValue(":cartId", $cartId, PDO::PARAM_INT);
        $stmt->bindValue(":productId", $productId, PDO::PARAM_INT);
        $stmt->bindValue(":unit_price", $unit_price, PDO::PARAM_INT);
        $stmt->bindValue(":purchase_quantity", $purchase_quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getCartItem($userId)
    {
        $stmt = $this->conn->prepare("select * from cart_item ci
                                        join cart c
                                        join products p
                                        on c.id = ci.cart_id and p.id = ci.product_id
                                        where c.user_id = :userId");
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
        $userCartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userCartItems;
    }

    public function updateCartQuantity($items)
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare(
                "update cart_item
                                      set purchase_quantity = :updatedCart, unit_price = :unit_price
                                      where product_id = :productId"
            );
            foreach ($items as $item) {
                $stmt->execute([
                    ":updatedCart" => $item["purchase_quantity"],
                    ":unit_price" => (int)$item["unit_price"],
                    ":productId" => $item["product_id"],
                ]);
            }
            $this->conn->commit();
            header("Location: /checkout");
            exit();
        } catch (Exception $exception) {
            $this->conn->rollback();
        }
    }
}
