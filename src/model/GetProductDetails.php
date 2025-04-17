<?php

namespace ayushtamang\FormHandeling\model;

class GetProductDetails
{
    private $sqlData;
    
    public function __construct(private $con, $input) 
    {
        $this->con = $con;
        
        if (is_array($input)) {
            $this->sqlData = $input;
        } else {
            $query = $this->con->prepare("SELECT * FROM products WHERE id = :id");
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function getProductId() 
    {
        return $this->sqlData["id"];
    }
    
    public function getProductName() 
    {
        return $this->sqlData["productName"];
    }

    public function getProductPrice() 
    {
        return $this->sqlData["productPrice"];
    }

    public function getProductQuantity() 
    {
        return $this->sqlData["productQuantity"];
    }

    public function getProductNumber()
    {
        $query = $this->con->prepare("SELECT * FROM products");
        $query->execute();

        return $query->rowCount();
    }

    public function getCreatedAt()
    {
        return $this->sqlData["createdAt"];
    }

    public function getUpdatedAt()
    {
        return $this->sqlData["updatedAt"];
    }
}
?>