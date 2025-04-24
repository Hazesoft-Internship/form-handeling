<?php

namespace App\Model;

require_once __DIR__. "/../../vendor/autoload.php";
use App\session\session;
use App\Model\Database;


class User extends GetConnection
{
    public function handlelogin($email, $password): void
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $result = $this->conn->query("SELECT * FROM users WHERE email='$email'");
            $user = $result->fetch();
            if($user)
            {
                if(password_verify($password, $user['password']))
                {
                    session::getInstance()->set("userID", $user["id"]);
                    session::getInstance()->set("isLoggedIn", TRUE);
                    session::getInstance()->set("userName", $user["firstName"]);
                    header("Location: /productManagement");
                }
                else
                {
                    echo "Login failed due to wrong password or username";
                    session::getInstance()->set("isLoggedIn", FALSE);
                }
            }
            else
            {
                echo "Email not found on database";
            }
        }
        else
        {
            header("Location: /");
         }
    }

    public function uploadUser($firstName, $middleName, $lastName, $address, $email, $password): void
    {
        $sql = "INSERT INTO users(firstName, middleName, lastName, email, address, password) VALUES (:firstName, :middleName, :lastName, :email, :address, :password)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) 
        {
            throw new RuntimeException("Unable to prepare the statement for user");
        }
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':middleName', $middleName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':password', $password);

        if (!$stmt->execute()) {
            throw new RuntimeException("Unable to execute the  for user");
        }
        else {
            header("Location: /");
        }
    }
}
