<?php

namespace App\controller;

use App\model\User;
use App\config\Database;
use App\validate\Seperator;


class UserController
{
    private $userModel;
    private $db;
    public function __construct()
    {
        $conn = Database::getInstance();
        $this->db = $conn->getConnection();
        $this->userModel = new User($this->db);
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
        session_unset();
        session_destroy();
        header("Location: /login");
    }

    public function insertCsv()
    {
        if ($this->userModel->insertFromCsv(__DIR__."/../data/user.csv")) {
            echo "successfully inserted";
        }
    }
}
