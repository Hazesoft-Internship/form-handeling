<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Model\Product;


class ProductController
{
    
    public function addproductpage(): void
    {
        require __DIR__ . '/../View/productadd.php';
    }
    public function addproduct(): void
    {
        $addproduct = new Product(new DbConnection());
        $addproduct->insertProduct();
    }
    public function myproductlist(): void
    {
        $viewproduct = new Product(new DbConnection());
        $row = $viewproduct->getmyProducts();
        require __DIR__ . '/../View/Viewproduct.php';
    }

    public function getallproduct(): void
    {

        $viewproduct = new Product(new DbConnection());
        $row = $viewproduct->viewallProducts();
        require __DIR__ . '/../View/viewallproduct.php';
    }
    public function updateproductpage(): void

    {

        require __DIR__ . '/../View/updateproduct.php';
    }
    public function updateproduct(): void
    {
        $updateproduct = new Product(new DbConnection());
        $updateproduct->updateProduct();
    }



    public function deleteproduct(): void
    {
        $deleteuser = new Product(new DbConnection());
        $deleteuser->deleteproduct();
    }
}
