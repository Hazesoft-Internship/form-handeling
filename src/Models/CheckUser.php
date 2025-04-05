<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Config\SessionHandler;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;

class CheckUser
{
    private $conn;
    public function __construct()
    {
        $connection = new Connection();
        $this->conn = $connection->connect();
    }
    public function checkUser($inputArray)
    {
        try {
            [$email, $password] = $inputArray;

            $stmt = $this->conn->prepare("SELECT `id`, `first_name`, `email`, `password` FROM users WHERE `email`= ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $userData = $stmt->get_result();
            // $sql = "SELECT `id`, `first_name`, `email`, `password` FROM users WHERE `email`='$email'";
            // $userData = $this->conn->query($sql);

            $row = $userData->fetch_assoc();
            $hashed_password = $row["password"];

            if (password_verify($password, $hashed_password)) {
                $session = new SessionHandler();
                $session->setSession("userId" , (int)$row["id"]);
                $session->setSession("firstName" , $row["first_name"]);
                $session->setSession("isLoggedIn" , true);
                return true;
            } else {
                echo ("Invalid password");
                return false;
            }
        } catch (Exception $exception) {
            echo ("Invalid email or password " . $exception->getMessage());
            return false;
        }
    }
}
