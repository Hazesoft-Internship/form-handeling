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

    // public function getCartItem($userId)
    // {
    //     $stmt = $this->conn->prepare("select * from cart_item ci
    //                                     join cart c
    //                                     join products p
    //                                     on c.id = ci.cart_id and p.id = ci.product_id
    //                                     where c.user_id = :userId");
    //     $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $userCartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $userCartItems;
    // }

    public function getCartItem($userId)
    {
        $stmt = $this->conn->prepare("select c.id as id, ci.cart_id as cartId, p.name as name, p.price as product_price, p.price as unit_price, p.quantity as quantity, ci.purchase_quantity as purchase_quantity,p.type as type, p.id as product_id, ci.cart_item_id as cart_item_id, (p.price * ci.purchase_quantity) as price from cart_item ci
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
            $priceStmt = $this->conn->prepare(
                "select quantity,price from products where id = :productId"
            );
            $stmt = $this->conn->prepare(
                                    "update cart_item
                                    set purchase_quantity = :purchase_quantity, unit_price = :unit_price
                                    where product_id = :productId"
            );
            foreach ($items as $item) {
                $priceStmt->execute([":productId" => $item["product_id"]]);
                $currentPrice = $priceStmt->fetch(PDO::FETCH_ASSOC);
                $quantity = (int)$item["purchase_quantity"];

                if($quantity > $currentPrice["quantity"]) {
                    throw new Exception("product is out of stock");
                }
                
                $calculate = (int)$currentPrice["price"] * $quantity; 
                $stmt->execute([
                    ":purchase_quantity" => $quantity,
                    ":unit_price" => (int)$calculate,
                    ":productId" => $item["product_id"],
                ]);
            }
            $this->conn->commit();
            header("Location: /checkout");
            exit();
        } catch (Exception $exception) {
            $this->conn->rollback();
            echo $exception->getMessage();
        }
    }

    public function deleteCartItem($cartItemId)
    {
        try {
            $stmt = $this->conn->prepare("delete from cart_item
                                          where cart_item_id = :cartItemId");
            $stmt->bindValue(":cartItemId", $cartItemId);
            $stmt->execute();
        } catch(Exception $exception) {
            echo $exception->getMessage();

        }    
    }

    public function ProductExistInCart($cartId, $productId) {
        try {
            $stmt = $this->conn->prepare("select * from cart_item where cart_id = :cartId and product_id = :productId");
            $stmt->execute(["cartId"=>$cartId,"productId"=>$productId]);
            return $stmt->rowCount() > 0;
        } catch(Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function incrementCartQuantity($cartId, $productId) {
        try {
            $stmt = $this->conn->prepare("
                update cart_item ci
                join products p ON ci.product_id = p.id
                set 
                    ci.purchase_quantity = ci.purchase_quantity + 1,
                    ci.unit_price = p.price * (ci.purchase_quantity + 1)
                where 
                    ci.cart_id = :cartId
                    and ci.product_id = :productId
                    and (ci.purchase_quantity + 1) <= p.quantity
            ");
            $stmt->execute([
                "cartId" => $cartId,
                "productId" => $productId
            ]);
            return $stmt->rowCount() > 0; 
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return false;
        }
    }   
}