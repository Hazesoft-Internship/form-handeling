<?php

require_once 'DbConnect.php';


class User
{

    public function __construct(private string $first_name, private string $middle_name, private string $last_name, private string $email, private string $address) {}


    public function insertUser($connection): void
    {

        if (!$connection) {
            throw new Exception("Connection not found");
        }

        try {
            $sql = "INSERT INTO users (first_name, middle_name, last_name, email, address) VALUES
        (?, ?, ?, ?, ?)";

            $statement = $connection->prepare($sql);

            $statement->bind_param("sssss", $this->first_name, $this->middle_name, $this->last_name, $this->email, $this->address);


            if (!$statement->execute()) {
                throw new Exception("Error executing query: " . $statement->error);
            }

            echo "New record created successfully";
        } catch (Exception $exception) {

            echo "Error: " . $exception->getMessage();
        }
    }
}
