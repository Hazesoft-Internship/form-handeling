<?php

namespace ayushtamang\FormHandeling\view;

use ayushtamang\FormHandeling\model\GetProductDetails;

class ProductGrid
{
    public function __construct(private $con)
    {
        $this->con = $con;
    }

    public function create(): string
    {
        if (empty($_SESSION["user_id"])) {
            $gridItems = $this->getAllProducts();
        } else {
            $gridItems = $this->getProducts();
        }

        return "<div>
                    <h1>Products</h1>
                    $gridItems
                    
                </div>";
    }

    public function getProducts(): string
    {
        $query = $this->con->prepare("SELECT * FROM products WHERE userId != ? ORDER BY RAND()");
        $query->bind_param("i", $_SESSION["user_id"]);
        $query->execute();

        $result = $query->get_result();

        $elementHTML = "";

        while ($row = $result->fetch_assoc()) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product);
            $elementHTML .= $item->create();
        }

        return $elementHTML;
    }

    public function getAllProducts(): string
    {
        $query = $this->con->prepare("SELECT * FROM products ORDER BY RAND()");
        $query->execute();

        $result = $query->get_result();

        $elementHTML = "";

        while ($row = $result->fetch_assoc()) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product);
            $elementHTML .= $item->create();
        }

        return $elementHTML;
    }

    public function getProductsByUserId(): string
    {
        $query = $this->con->prepare("SELECT * FROM products WHERE userId = ?");
        $query->bind_param("i", $_SESSION["user_id"]);
        $query->execute();

        $result = $query->get_result();

        $elementHTML = "";

        while ($row = $result->fetch_assoc()) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product);
            $elementHTML .= $item->create();
        }

        return "<div>
                    <h1>Products</h1>
                    $elementHTML
                    <a href='productStore.php'>Back</a>
                </div>";
    }
}
?>