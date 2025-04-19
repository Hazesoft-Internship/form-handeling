<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\session\Session;
use PDO;
use Exception;

class CartModel
{
    private $conn;
    private $cartId;
    private Session $session; // Store the session instance
    public function __construct(DbConnection $dbConnection, Session $session)
    {

        $this->conn = $dbConnection->getConnection();
        $this->session = Session::getInstance();
        $this->cartId = $this->session->getCartId(); // Get the cart ID from the session
    }

    public function addProduct($productId, $quantity, $productName, $description): void
    {
        // echo $this->cartId;
        try {
            if ($this->cartId) {


                // If logged in, add to DB
                $stmt = $this->conn->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
                $stmt->bindValue(1, $this->cartId, PDO::PARAM_INT);
                $stmt->bindValue(2, $productId, PDO::PARAM_INT);
                $stmt->execute();
                $existing = $stmt->fetch();

                if ($existing) {
                    $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?");
                    $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
                    $stmt->bindValue(2, $this->cartId, PDO::PARAM_INT);
                    $stmt->bindValue(3, $productId, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "Product quantity updated successfully.";
                    } else {
                        echo "Failed to update product quantity.";
                    }
                } else {
                    $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?,?,?)");
                    $stmt->bindValue(1, $this->cartId, PDO::PARAM_INT);
                    $stmt->bindValue(2, $productId, PDO::PARAM_INT);
                    $stmt->bindValue(3, $quantity, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        echo "Product added to cart successfully.";
                    } else {
                        echo "Failed to add product to cart.";
                    }
                }
            } else {
                // If not logged in, use session

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                    echo "Product quantity updated in session cart.";
                } else {
                    $_SESSION['cart'][$productId] = [
                        'productId' => $productId,
                        'description' => $description,
                        'quantity' => $quantity,
                        'name' => $productName,

                    ];
                    echo "Product added to session cart.";
                }
            }
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    public function viewCart()
    {
        try {


            if ($this->cartId) {
                $stmt = $this->conn->prepare("
                SELECT 
                    ci.cart_item_id,
                    p.productID,
                    p.productName  AS name,
                    p.price,
                    p.description,
                    ci.quantity
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.productID
                WHERE ci.cart_id = ?
            ");

                $stmt->bindValue(1, $this->cartId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $cartItems;
                } else {
                    echo "Failed to fetch cart items.";
                    return [];
                }
            } else {
                //  session if not logged in
                if (isset($_SESSION['cart'])) {
                    $cart = $_SESSION['cart'];
                    foreach ($cart as &$item) {
                        $item['price'] = 0;
                    }
                    return $cart;
                }
                return [];
            }
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }


    public function updateCart($productId,  $quantity, $cart_itemsId, $Maxquantity): void
    {
        try {
            if ($quantity > $Maxquantity) {
                echo "Quantity exceeds available stock.";
                return;
            }


            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = ? WHERE cart_item_id = ? AND product_id = ?");
            $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
            $stmt->bindValue(2, $cart_itemsId, PDO::PARAM_INT);
            $stmt->bindValue(3, $productId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Product quantity updated successfully.";
            } else {
                echo "Failed to update product quantity.";
            }
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    public function removeProduct($productId): void
    {

        try {
            if ($this->cartId) {
                // If logged in, remove from DB

                $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
                $stmt->bindValue(1, $this->cartId, PDO::PARAM_INT);
                $stmt->bindValue(2, $productId, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    echo "Product removed from cart successfully.";
                } else {
                    echo "Failed to remove product from cart.";
                }
            } else {
                // If not logged in, use session
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}
