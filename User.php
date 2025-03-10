<?php

require_once "upload.php";

class User
{
    private $connection;
    public function __construct()
    {
        echo "<br>this is inside the constructor for USER<br>";
        // $this->connection = $conn;// this code doesnt work for some reason so i manually created the mysqli connection.
        $this->connection = new mysqli ('localhost', 'root', '', 'mysql1');
    }

    public function createUser($firstName, $middleName, $lastName, $address, $email)
    {
        $stmt = $this->connection->prepare("INSERT INTO users(firstName, middleName, lastName, email, address) VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new RuntimeException("Unable to prepare the statement");

        }
        $stmt->bind_param("sssss", $firstName, $middleName, $lastName, $email, $address);

        if (!$stmt->execute()) {
            throw new RuntimeException("Unable to execute the query");
        }
        else {
            echo "<br>User sucessfully added to database<br>";
        }

        return true;

    }
}