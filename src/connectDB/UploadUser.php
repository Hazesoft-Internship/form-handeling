<?php

namespace App\connectDB;
require_once __DIR__."/../../vendor/autoload.php";
use App\connectDB\Database;

class UploadUser
{
    private $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function createUser($firstName, $middleName, $lastName, $address, $email, $password): void
    {
        $stmt = $this->connection->prepare("INSERT INTO users(firstName, middleName, lastName, email, address, password) VALUES (:firstName, :middleName, :lastName, :email, :address, :password)");

        if (!$stmt) {
            throw new RuntimeException("Unable to prepare the statement for user");
        }
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':secondName', $middleName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':password', $password);

        if (!$stmt->execute()) {
            throw new RuntimeException("Unable to execute the  for user");
        }
        else {
            echo "<br>User sucessfully added to database<br>";
        }
    }
}