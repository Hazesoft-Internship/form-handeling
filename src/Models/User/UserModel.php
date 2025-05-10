<?php

namespace App\Models\User;



use App\Models\Model;
use App\Sessions\Sessions;
use Exception;
use PDO;

class UserModel extends Model
{

    public function signup(string $first_name, string $middle_name, string $last_name, string $email, string $address, string $password): void
    {



        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $email, PDO::PARAM_STR);

            if ($statement->execute()) {

                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if (!$result == false) {
                    throw new Exception("Email already exists");
                }
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }


            $sql = "INSERT INTO users (first_name, middle_name, last_name, email, address,password) VALUES
        (?, ?, ?, ?, ?,?)";

            $statement = $this->connection->prepare($sql);

            // $statement->bind_param("ssssss", $first_name, $middle_name, $last_name, $email, $address, $password,);
            $statement->bindParam(1, $first_name, PDO::PARAM_STR);
            $statement->bindParam(2, $middle_name, PDO::PARAM_STR);
            $statement->bindParam(3, $last_name, PDO::PARAM_STR);
            $statement->bindParam(4, $email, PDO::PARAM_STR);
            $statement->bindParam(5, $address, PDO::PARAM_STR);
            $statement->bindParam(6, $password, PDO::PARAM_STR);





            if ($statement->execute()) {
                echo "User registered successfully!";
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        } catch (Exception $exception) {

            echo "Error: " . $exception->getMessage();
        }
    }

    public function login(string $email, string $password): void
    {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $statement = $this->connection->prepare($sql);
            // $statement->bind_param("s", $email);
            $statement->bindParam(1, $email, PDO::PARAM_STR);

            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);


            if ($result == false) {
                throw new Exception("User not found");
            }
            if ($result && password_verify($password, $result['password'])) {
                $this->session->setSession('user', $result);
                // $_SESSION['user'] = $user;
                echo "Login successful!";
            } else {
                throw new Exception("Invalid email or password");
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
