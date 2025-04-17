<?php

namespace ayushtamang\FormHandeling\model;

class Cart
{
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function addCart($userId)
    {
        try {
            $query = $this->con->prepare("INSERT INTO carts (userId) VALUES (:ui)" );
            $query->bindParam(":ui", $userId);
            
            return $query->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("AddCart failed!");
        }
    }

    public function deleteCart($userId)
    {
        try {
            $query = $this->con->prepare("DELETE FROM cart WHERE userId = :ui");
            $query->bindParam(":ui", $userId);

            return $query->execute();
        } catch (\PDOException $e) {
            throw new \PDOException("DeleteCart failed!");
        }
    }
}
?>