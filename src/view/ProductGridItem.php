<?php

namespace ayushtamang\FormHandeling\view;

class ProductGridItem
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function create()
    {
        $product = $this->productList();
        $url = "productPage.php";

        return "<div>
                    $product
                    <a href='$url'>Buy</a>                    
                </div>
                ";
    }

    public function productList()
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
}
?>