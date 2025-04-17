<?php

namespace ayushtamang\FormHandeling\controls\product_controls;

use ayushtamang\FormHandeling\session\Session;
use ayushtamang\FormHandeling\traits\DateTimeFormatter;

class ProductGridItem
{
    use DateTimeFormatter;
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
        $createdAt = $this->convertTime($this->products->getCreatedAt());
        $updatedAt = $this->convertTime($this->products->getUpdatedAt());

        return "<div>
                    <label>Name: </label>
                    $productName
                    <label>Quantity: </label>
                    $productQuantity
                    <label>Price: </label>
                    $productPrice
                    <label>CreatedAt: </label>
                    $createdAt
                    <label>UpdatedAt: </label>
                    $updatedAt
                    <br>
                </div>";
    }

    public function button(string $placeholder): string
    {
        return "<input type='submit' name='$placeholder' value='$placeholder'>";
    }
    
    public function fetchSingleProduct($name)
    {
        $session = Session::getInstance();

        if (!isset($_GET["id"])) {
            return "Error: ID parameter is missing.";
        }

        $id = $_GET["id"];
        $session->setSession("productId", $id);

        $query = $this->con->prepare("SELECT * FROM products WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();

        $sqlData = [];
        $sqlData = $query->fetch(\PDO::FETCH_ASSOC);

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

        $createdAt = $this->convertTime($this->products->getCreatedAt());
        $updatedAt = $this->convertTime($this->products->getUpdatedAt());
        
        return "<form onsubmit='onUpdate(event)' action='$action' method='POST'>
                    <label>Name: </label>
                    $productName
                    <label>Quantity: </label>
                    $productQuantity
                    <label>Price: </label>
                    $productPrice
                    <label>CreatedAt: </label>
                    $createdAt
                    <label>UpdatedAt: </label>
                    $updatedAt
                    <br>
                    $button
                </form>
                <form onsubmit='onDelete(event)' action='/product/profile/deleteSubmit' method='POST'>
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

        return "<input type='number' name='productquantity' placeholder='Product Quantity' value='$value'>";
    }

    public function updateProductPrice($value): string
    {
        if($value == null) {
            $value = "";
        }

        return "<input type='number' name='productprice' placeholder='Product Price' value='$value'>";
    }

    public function buyProduct($button)
    {
        $productName = $this->fetchSingleProduct("productName");
        $productQuantity = $this->fetchSingleProduct("productQuantity");
        $productPrice = $this->fetchSingleProduct("productPrice");

        $id = $_GET["id"];

        return "<div>
                    <label>Name: </label>
                    $productName
                    <br>
                    <label>Quantity: </label>
                    $productQuantity
                    <br>
                    <label>Price: </label>
                    $productPrice
                    <form action='/product/buy/addcartsubmit?id=$id' method='POST'>
                        <input type='number' name='quantity' min='1' max='$productQuantity' value='1'>
                        $button
                    </form>
                </div>";
    }
}
?>