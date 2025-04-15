<?php

namespace Hazesoft\Backend\Controllers\Frontend;

use Hazesoft\Backend\Models\Product;
use Hazesoft\Backend\Services\Session;

class HomePageController
{
    public function getHomepage()
    {
        $viewData = $this->handleHomePageData();
        extract($viewData);
        return require_once __DIR__ . '/../../Views/homepage.php';
    }

    public function handleHomePageData(): array
    {
        $session = Session::getInstance();
        $productObject = new Product();

        $isLoggedIn = $session->getSession("isLoggedIn");
        $userId = $session->getSession("userId");

        $allProducts = $productObject->getAllProducts();
        $myProducts = $productObject->getUserProducts($userId);

        return [
            'session' => $session,
            'isLoggedIn' => $isLoggedIn,
            'userId' => $userId,
            'allProducts' => $allProducts,
            'myProducts' => $myProducts
        ];
    }
}