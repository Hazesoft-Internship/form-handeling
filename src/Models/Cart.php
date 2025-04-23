<?php

namespace ECommerce\Models;

use PDOException;
use PDO;
use PDOStatement;

final class Cart extends ModelDBConnection
{
    public function getCartByUserID(int $userID): array|string
    {
        try {
            $getCartByIDQuery = "SELECT * FROM carts WHERE userID = :userID";
            $statement = $this->dbConnection->prepare($getCartByIDQuery);
            $statement->bindParam(':userID', $userID);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function createUserCart(int $userID): PDOStatement|string
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
