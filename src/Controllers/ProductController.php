<?php

declare(strict_types=1);

namespace src\Controllers;

use src\Models\Product;
use src\Exceptions\ValidationException;
use src\Exceptions\DatabaseException;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /public/index.php?controller=User&action=login');
            exit;
        }

        $products = $this->productModel->getUserProducts($_SESSION['user_id']);

        // Loading the view
        require __DIR__ . '/../../views/product/list.php';
    }

    public function all(): void {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $products = $this->productModel->getOtherUsersProducts($_SESSION['user_id']);
        require __DIR__ . '/../../views/product/all.php';
    }
}
