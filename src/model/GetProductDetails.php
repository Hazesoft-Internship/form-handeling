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
            $query = $this->con->prepare("SELECT * FROM products WHERE id = ?");
            $query->bind_param("i", $input);
            $query->execute();

            $result = $query->get_result();
            $this->sqlData = $result->fetch_assoc();
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
        $result = $query->get_result();

        return $result->num_rows;
    }
}
?>