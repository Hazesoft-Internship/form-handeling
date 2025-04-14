<?php

namespace App\controller;
use App\validate\Seperator;
use App\controller\Constructor;


class UserController extends Constructor
{

    public function displayRegister()
    {
        include(__DIR__ . "/../view/register.php");
    }

    public function displayLogin()
    {
        include(__DIR__ . "/../view/login.php");
    }

    public function register()
    {
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $address = $_POST["address"];
        $result = Seperator::seperate($fullName);
        $result["email"] = $email;
        $result["address"] = $address;
        $result["password"] = $hashed_password;
        $this->userModel->register($result);
    }

    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $this->userModel->login($email, $password);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        session_unset();
        header("Location: /login");
    }

    public function insertCsv()
    {
        if ($this->userModel->insertFromCsv(__DIR__."/../data/user.csv")) {
            echo "successfully inserted";
        }
    }
}
