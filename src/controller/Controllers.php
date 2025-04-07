<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Module\Product;


class Controllers
{
    public function signUp(): void
    {
        require __DIR__ . '/../View/Signup.php';
    }
    public function insertUser(): void
    {
        require __DIR__ . '/../Module/InsertUser.php';
    }

    public function loginpage(): void
    {
        require __DIR__ . '/../View/loginpage.php';
    }
    public function login(): void
    {
        require __DIR__ . '/../Module/Login.php';
    }
    public function dashboard(): void
    {
        require __DIR__ . '/../View/dashboard.php';
    }
    public function addproductpage(): void
    {
        require __DIR__ . '/../View/productadd.php';
    }
    public function addproduct(): void
    {
        $addproduct = new Product(new DbConnection());
        $addproduct->insertProduct();
    }
    public function productlist(): void
    {

        require __DIR__ . '/../View/Viewproduct.php';
    }
    public function updateproductpage(): void
    {
        // $updateproduct = new Product(new DbConnection());
        // $updateproduct->updateProduct();
        require __DIR__ . '/../View/updateproduct.php';
    }
    public function updateproduct(): void
    {
        $updateproduct = new Product(new DbConnection());
        $updateproduct->updateProduct();
    }
    // public static function deleteproductID($id): void //Todo work here
    // {
    //     //    echo $id;
    //     //    echo"here";
    //     // $deleteproduct = new Product(new DbConnection());
    //     // $deleteproduct->deleteProduct($id);
    // }

    public static function deleteproductpage(): void
    {

        require __DIR__ . '/../View/inputform.php';
    }
    public function deleteproduct(): void
    {
        $deleteuser = new Product(new DbConnection());
        $deleteuser->deleteproduct();
    }
    public function logout(): void
    {

        session_destroy();
        header("Location: /login");
        exit();
    }
}
