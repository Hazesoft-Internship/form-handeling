<?php

namespace App\Models;



use App\Config\DataBase;
use App\Sessions\Sessions;
use Exception;

class UserModel
{
    public object $connection;
    public object $session;

    public function __construct()
    {

        $this->connection = DataBase::connect();
        $this->session = new Sessions;
    }


    public function signup(string $first_name, string $middle_name, string $last_name, string $email, string $address, string $password): void
    {

        try {

            try {
                $sql = "SELECT * FROM users WHERE email = ?";
                $statement = $this->connection->prepare($sql);
                $statement->bind_param("s", $email);
                if ($statement->execute()) {
                    $result = $statement->get_result();
                    if ($result->num_rows > 0) {
                        throw new Exception("Email already exists");
                    }
                } else {
                    throw new Exception("Error executing query: " . $statement->error);
                }
                $statement->close();
            } catch (Exception $exception) {
                echo "Error: " . $exception->getMessage();
                return;
            }

            $sql = "INSERT INTO users (first_name, middle_name, last_name, email, address,password) VALUES
        (?, ?, ?, ?, ?,?)";

            $statement = $this->connection->prepare($sql);

            $statement->bind_param("ssssss", $first_name, $middle_name, $last_name, $email, $address, $password,);


            if ($statement->execute()) {
                echo "User registered successfully!";
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
            $statement->close();
        } catch (Exception $exception) {

            echo "Error: " . $exception->getMessage();
        }
    }

    public function login(string $email, string $password): void
    {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("s", $email);

            $statement->execute();

            $result = $statement->get_result();
            $user = $result->fetch_assoc();
            if ($user && password_verify($password, $user['password'])) {
                $this->session->setSession('user', $user);
                // $_SESSION['user'] = $user;
                echo "Login successful!";
            } else {
                throw new Exception("Invalid email or password");
            }
            $statement->close();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
