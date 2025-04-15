<?php

namespace App\controller;
require_once __DIR__."/../../vendor/autoload.php";
// session_start();
use App\connectDB\Database;
use App\session\session;

class CheckLogin
{
    public $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    public function login()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $email = $_POST["email"];
            session::getInstance()->set("email", $email);
            $password = $_POST["password"];
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
            header("Location: ../dashboard/login.php");
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $check1 = new checkLogin();
    $check1->login();
}
?>