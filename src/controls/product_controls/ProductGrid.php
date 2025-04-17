<?php

namespace ayushtamang\FormHandeling\controls\product_controls;

use ayushtamang\FormHandeling\model\GetProductDetails;
use ayushtamang\FormHandeling\session\Session;

class ProductGrid
{
    private $session;
    private $id;
    public function __construct(private $con)
    {
        $this->con = $con;
        $this->session = Session::getInstance();
        $this->id = $this->session->getSession("userId");
    }
    
    public function create(): string
    {
        if (empty($this->id)) {
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
        $query = $this->con->prepare("SELECT * FROM products WHERE userId != :ui ORDER BY RAND()");
        $query->bindParam("ui", $this->id);
        $query->execute();

        $elementHTML = "";

        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product, $this->con);
            $elementHTML .= $item->create("/product/buy", "Buy");
        }

        return $elementHTML;
    }

    public function getAllProducts(): string
    {
        $query = $this->con->prepare("SELECT * FROM products ORDER BY RAND()");
        $query->execute();

        $elementHTML = "";

        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product, $this->con);
            $elementHTML .= $item->create("/product/buy", "Buy");
        }

        return $elementHTML;
    }

    public function getProductsByUserId(): string
    {
        $query = $this->con->prepare("SELECT * FROM products WHERE userId = :ui");
        $query->bindParam(":ui", $this->id);
        $query->execute();

        $elementHTML = "";

        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $product = new GetProductDetails($this->con, $row);
            $item = new ProductGridItem($product, $this->con);
            $elementHTML .= $item->create("/product/profile/update", "ShowMore");
        }

        if (empty($elementHTML)) {
            $elementHTML = "<span>No! products to show.</span>";
        }

        return "<div>
                    <h1>Products</h1>
                    $elementHTML
                    <br><a href='/product'>Back</a>
                </div>";
    }

    public function updateProduct(): string
    {
        $query = $this->con->prepare("SELECT * FROM products WHERE userId = :ui");
        $query->bindParam(":ui", $this->id);
        $query->execute();
    
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        
        $product = new GetProductDetails($this->con, $row);
        $item = new ProductGridItem($product, $this->con);
        $updateHTML = $item->button("Update");
        $elementHTML = $item->createFrom("/product/profile/updateSubmit", $updateHTML);

        return "<div>
                    <h1>Update Product</h1>
                    $elementHTML
                    <a href='/product/profile'>Back</a>
                </div>";
    }

    public function getBuyProduct(): string
    {
        $query = $this->con->prepare("SELECT * FROM products WHERE userId = :ui");
        $query->bindParam(":ui", $this->id);
        $query->execute();

        $product = new GetProductDetails($this->con, $query->fetch(\PDO::FETCH_ASSOC));
        $item = new ProductGridItem($product, $this->con);
        $button = $item->button("Add Cart");
        $elementHTML = $item->buyProduct($button);

        if (empty($elementHTML)) {
            $elementHTML = "<span>No! products to show.</span>";
        }

        return "<div>
                    <h1>Product</h1>
                    $elementHTML
                    <a href='/product'>Back</a>
               </div>";
    }
}
?>