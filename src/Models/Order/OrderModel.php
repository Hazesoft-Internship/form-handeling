<?php

namespace App\Models\Order;

use App\Config\DataBase;
use App\Models\Model;
use App\Sessions\Sessions;
use Exception;
use PDO;

class OrderModel extends Model
{

    public function insertOrder(string $address, string $payment_method, int $user_id, float $total_shipping, float $total_discount, float $tax, float $total): bool
    {
        try {
            $insertOrderQuery = "INSERT INTO orders (address,payment_method,user_id,total_shipping,total_discount,tax,total) VALUES(?,?,?,?,?,?,?)";
            $statement = $this->connection->prepare($insertOrderQuery);
            $statement->bindParam(1, $address, PDO::PARAM_STR);
            $statement->bindParam(2, $payment_method, PDO::PARAM_STR);
            $statement->bindParam(3, $user_id, PDO::PARAM_INT);
            $statement->bindParam(4, $total_shipping);
            $statement->bindParam(5, $total_discount);
            $statement->bindParam(6, $tax);
            $statement->bindParam(7, $total);




            if ($statement->execute()) {
                return true;
            }



            return false;
        } catch (\PDOException $e) {
            echo "Error" . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error" . $e->getMessage();
            return false;
        }
    }
}
