<?php

namespace Lattefront\FormHandeling\Service;

use PDO;
use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\session\Session;
use Lattefront\FormHandeling\Model\Product;

class CartService
{
    private $conn;
    private Session $session;

    function __construct(DbConnection $dbConnection, Session $session)
    {
        $this->session = $session::getInstance();
        $this->conn = $dbConnection->getConnection();
    }

    public function migrateFromSession(): void
    {
        $cartId = $this->getCartId();
        $this->session->setCartId($cartId);

        if ($_SESSION['cart']) {
            $sessionCart = $_SESSION['cart'];
            $loggedinId = $this->session->getUserId();

            $prodquantity = new Product(new DbConnection());


            foreach ($sessionCart as $productId => $quantity) {
                $createdby = $prodquantity->getproductdetails($productId);
                $createdBy = $createdby[1];


                if ($createdBy == $loggedinId) {
                    echo "Skipping own product (ID: $productId)";
                    continue;
                }
                $stmt = $this->conn->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
                $stmt->bindValue(1, $cartId, PDO::PARAM_INT);
                $stmt->bindValue(2, $productId, PDO::PARAM_INT);
                $stmt->execute();
                $existing = $stmt->fetch();

                if ($existing) {
                    $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?");
                    $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
                    $stmt->bindValue(2, $cartId, PDO::PARAM_INT);
                    $stmt->bindValue(3, $productId, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?,?,?)");
                    $stmt->bindValue(1, $cartId, PDO::PARAM_INT);
                    $stmt->bindValue(2, $productId, PDO::PARAM_INT);
                    $stmt->bindValue(3, $quantity, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            unset($_SESSION['cart']); // Clear the session cart after migration
        }
    }
    public function getCartId()
    {
        $stmt = $this->conn->prepare("SELECT cart_id FROM carts WHERE user_id = ?");
        $stmt->bindValue(1, $this->session->getUserId(), PDO::PARAM_INT);
        $stmt->execute();
        $cartId = $stmt->fetchColumn();

        if ($cartId === false) {
            return null;
        }
        return $cartId;
    }
}
