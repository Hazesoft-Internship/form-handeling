<?php

namespace ayushtamang\FormHandeling\model;

class UploadProduct
{
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function addProduct($ui, $pn, $pp, $pq) 
    {
        $query = $this->con->prepare("INSERT INTO products (userId, productName, productPrice, productQuantity) 
                                    VALUES (?, ?, ?, ?)");
        $query->bind_param("isdi", $ui, $pn, $pp, $pq);
        
        return $query->execute();
    }
}
?>