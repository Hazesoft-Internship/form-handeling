<?php

namespace App\Model;
require_once __DIR__."/../../vendor/autoload.php";

use App\Model\GetConnection;
use App\session\session;

class Cart extends GetConnection
{
    public function showCarts($userID): array
    {
        $sql = "SELECT 
                    c.quantity,
                    p.productName,
                    p.price,
                    c.id,
                    c.productID
                FROM
                    carts AS c
                INNER JOIN 
                    products AS p ON c.productID = p.id
                WHERE
                    c.userID = $userID
        ";
        $result = $this->conn->query($sql);
        return $result->fetchAll(); 
    }

    public function createCart($id): array
    {
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $this->conn->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function uploadCart($productID, $userID): void
    {
        $sql2 = "SELECT * FROM products WHERE id = $productID";
        $result2 = $this->conn->prepare($sql2);
        $result2->execute();
        $data2 = $result2->fetchAll();
        
        $sql1 = "SELECT * FROM carts WHERE productID = $productID";
        $result1 = $this->conn->prepare($sql1);
        $result1->execute();
        $data1 = $result1->fetchAll();
        if ($data1)
        {
            foreach($data1 as $row)
            {
                $updatedQuantity = $quantity + $row["quantity"];
            }
            if($data2)
            {
                foreach($data2 as $row)
                {
                    if($updatedQuantity > $row["quantity"])
                    {
                        echo "you have ordered $updatedQuantity items<br> But the no of items available is : ".$row['quantity'];
                        die();
                    }
                }
            }
            foreach($data1 as $row)
            {
                $sql2 = "UPDATE carts SET quantity=$updatedQuantity where productID = $productID";
                $result2 = $this->conn->prepare($sql2);
                $result2->execute();
                header("Location: /viewYourCart");
            }
        }
        else
        {
            if($data2)
            {
                foreach($data2 as $row)
                {
                    if($quantity>$row["quantity"])
                    {
                        echo "the number of order is invalid";
                        die();
                    }
                }
            }
            $stmt = $this->conn->prepare("INSERT INTO carts(userID, productID, quantity) VALUES (:userID, :productID, :quantity)");
            if(!$stmt)
            {
                die("unable to create cart");
            }
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':productID', $productID);
            $stmt->bindParam(':quantity', $quantity);

            if(!$stmt->execute())
            {
                throw new RuntimeException("Unable to execute query for Carts");
            }
            else
            {
                header("Location: /viewYourCart");
            }
        }
    }

    public function showUpdateCart($cartID, $productID): array
    {
        $sql = "SELECT * FROM products WHERE id = $productID";
        $result = $this->conn->query($sql);
        return $result->fetchAll();
    }

    public function updateCart($cartID, $updatedQuantity, $productID): void
    {
        $sql = "SELECT * FROM products WHERE id = $productID";
        $result = $this->conn->prepare($sql);
        $result->execute();
        $data = $result->fetchAll();
        if($data)
            {
                foreach($data as $row)
                {
                    if($updatedQuantity>$row["quantity"])
                    {
                        echo "Sorry!, <br> We only have" .$row['quantity'] ." items";
                        die();
                    }
                }
            }
        $sql = "UPDATE carts SET quantity=$updatedQuantity WHERE id=$cartID";
        if(($this->conn->query($sql)) == TRUE)
        {
            echo "updated the cart sucessfully";
        }
        else
        {
            echo "update failed";
        }
    }

    public function deleteCart($id): void
    {
        $sql = "DELETE FROM carts WHERE id=$id";
        if(($this->conn->query($sql)) == TRUE)
        {
            header("Location: /productManagement");
        }
        else
        {
            echo "deletion failed";
        }
    }
}
