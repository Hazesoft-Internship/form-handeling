<?php

namespace ECommerce\Models;

use ECommerce\Services\DatabaseConnection;
use PDOException;
use PDO;

final class Cart
{
    private $dbConnection;
    public function __construct()
    {
        $this->dbConnection = DatabaseConnection::getInstance();
    }

    public function getCartByUserID($userID)
    {
        try {
            $getCartByIDQuery = "SELECT * FROM carts WHERE userID= :userID";
            $statement = $this->dbConnection->prepare($getCartByIDQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function createUserCart($userID)
    {
        try {
            $createUserCartQuery = 'INSERT INTO carts(userID) VALUES(:userID)';
            $statement = $this->dbConnection->prepare($createUserCartQuery);
            $statement->bindParam(':userID', $userID);
            return $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    
}
