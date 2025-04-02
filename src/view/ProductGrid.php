<?php

namespace ayushtamang\FormHandeling\view;

use ayushtamang\FormHandeling\model\GetProductDetails;
use ayushtamang\FormHandeling\session\Session;

class ProductGrid
{
    public function __construct(private $con)
    {
        $this->con = $con;
    }

    public function create(): string
    {
        $id = Session::getSession("userId");

        if (empty($id)) {
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
        $id = Session::getSession("userId");

        $query = $this->con->prepare("SELECT * FROM products WHERE userId != ? ORDER BY RAND()");
        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();

        $elementHTML = "";

        while ($row = $result->fetch_assoc()) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product, $this->con);
            $elementHTML .= $item->create("productPage.php", "Buy");
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
            $item = new ProductGridItem($product, $this->con);
            $elementHTML .= $item->create("productPage.php", "Buy");
        }

        return $elementHTML;
    }

    public function getProductsByUserId(): string
    {
        $id = Session::getSession("userId");

        $query = $this->con->prepare("SELECT * FROM products WHERE userId = ?");
        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();

        $elementHTML = "";

        while ($row = $result->fetch_assoc()) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product, $this->con);
            $elementHTML .= $item->create("updateProduct.php", "ShowMore");
        }

        if (empty($elementHTML)) {
            $elementHTML = "<span>No! products to show.</span>";
        }

        return "<div>
                    <h1>Products</h1>
                    $elementHTML
                    <br><a href='productStore.php'>Back</a>
                </div>";
    }

    public function updateProduct()
    {
        $id = Session::getSession("userId");

        $query = $this->con->prepare("SELECT * FROM products WHERE userId = ?");
        $query->bind_param("i", $id);
        $query->execute();
        
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        
        $product = new GetProductDetails($this->con, $row);
        $item = new ProductGridItem($product, $this->con);
        $updateHTML = $item->button("Update");
        $elementHTML = $item->createFrom("updateProduct.php", $updateHTML);

        return "<div>
                    <h1>Update Product</h1>
                    $elementHTML
                    <a href='productProfile.php'>Back</a>
                </div>";
    }

    
}
?>