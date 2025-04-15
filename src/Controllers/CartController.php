<?php

declare(strict_types=1);

namespace src\Controllers;

use src\Models\Cart;
use src\Exceptions\ValidationException;

class CartController {
    private Cart $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function add(): void {
        session_start();
        $this->ensureLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->cartModel->addItem(
                    $_SESSION['user_id'],
                    (int)$_POST['product_id'],
                    (int)$_POST['quantity']
                );
                header('Location: /products/all');
            } catch (ValidationException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function view(): void {
        session_start();
        $this->ensureLoggedIn();

        $items = $this->cartModel->getCartItems($_SESSION['user_id']);
        require __DIR__ . '/../../views/cart/view.php';
    }

    public function update(): void {
        session_start();
        $this->ensureLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['quantity'] as $productId => $quantity) {
                try {
                    $this->cartModel->updateItem(
                        $_SESSION['user_id'],
                        (int)$productId,
                        (int)$quantity
                    );
                } catch (ValidationException $e) {
                    echo $e->getMessage();
                    exit;
                }
            }
            header('Location: /cart');
        }
    }

    private function ensureLoggedIn(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}