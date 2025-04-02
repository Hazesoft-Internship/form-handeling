<?php

namespace ayushtamang\FormHandeling\model;

class Product
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

    public function updateProduct($ui, $pn, $pp, $pq, $id)
    {
        $query = $this->con->prepare("UPDATE products SET userId = ?, productName = ?, productPrice = ?, productQuantity = ? WHERE id = ?");
        $query->bind_param("isdii", $ui, $pn, $pp, $pq, $id);
        
        return $query->execute();
    }

    public function deleteProduct($id)
    {
        $query = $this->con->prepare("DELETE FROM products WHERE id = ?");
        $query->bind_param("i", $id);

        return $query->execute();
    }
}
?>