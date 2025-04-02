<?php

namespace ayushtamang\FormHandeling\view;

use ayushtamang\FormHandeling\session\Session;

class ProductGridItem
{
    private $products;

    public function __construct($products, private $con)
    {
        $this->products = $products;
        $this->con = $con;
    }

    public function create(string $url, string $placeholder): string
    {
        $product = $this->productList();
        $id = $this->products->getProductId();

        return "$product
                <a href='$url?id=$id'>
                    <input type='submit' name='$placeholder' value='$placeholder'>
                </a>";
    }

    public function productList(): string
    {
        $productName = $this->products->getProductName();
        $productQuantity = $this->products->getProductQuantity();
        $productPrice = $this->products->getProductPrice();

        return "<div>
                    <label>Name: </label>
                    $productName
                    <label>Quantity: </label>
                    $productQuantity
                    <label>Price: </label>
                    $productPrice
                    <br>
                </div>";
    }

    public function button(string $placeholder): string
    {
        return "<input type='submit' name='$placeholder' value='$placeholder'>";
    }
    
    public function fetchSingleProduct($name)
    {
        if (!isset($_GET["id"])) {
            return "Error: ID parameter is missing.";
        }

        $id = $_GET["id"];
        Session::setSession("productId", $id);

        $query = $this->con->prepare("SELECT * FROM products WHERE id=?");
        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();
        $sqlData = [];
        $sqlData = $result->fetch_assoc();

        if (!$sqlData) {
            return "Error: Product not found.";
        }
        
        return $sqlData[$name];
    }

    public function createFrom($action, $button): string
    {
        $productName = $this->updateProductName($this->fetchSingleProduct("productName"));
        $productQuantity = $this->updateProductQuantity($this->fetchSingleProduct("productQuantity"));
        $productPrice = $this->updateProductPrice($this->fetchSingleProduct("productPrice"));
        $deleteButton = $this->button("Delete");
        
        return "<form onsubmit='onUpdate(event)' action='$action' method='POST'>
                    <label>Name: </label>
                    $productName
                    <label>Quantity: </label>
                    $productQuantity
                    <label>Price: </label>
                    $productPrice
                    <br>
                    $button
                </form>
                <form onsubmit='onDelete(event)' action='productProfile.php' method='POST'>
                    $deleteButton
                </form>";
    }

    public function updateProductName($value): string
    {
        if($value == null) {
            $value = "";
        }

        return "<input type='text' name='productname' placeholder='Product Name' value='$value'>";
    }

    public function updateProductQuantity($value): string
    {
        if($value == null) {
            $value = "";
        }

        return "<input type='text' name='productquantity' placeholder='Product Quantity' value='$value'>";
    }

    public function updateProductPrice($value): string
    {
        if($value == null) {
            $value = "";
        }

        return "<input type='text' name='productprice' placeholder='Product Price' value='$value'>";
    }
}
?>