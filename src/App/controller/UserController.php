<?php

namespace App\controller;

error_reporting(E_ALL);
ini_set('display_errors', 1);


use App\validate\Seperator;
use App\validate\Validation;
use App\model\User;
use CustomException;

class UserController
{
    private $conn;
    private Validation $validate;
    public function __construct($db)
    {
        $this->conn = $db;
        $this->validate = new Validation();
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "something went wrong";
            return;
        }
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $address = $_POST["address"];
        $result = Seperator::seperate($fullName);
        $result["email"] = $email;
        $result["address"] = $address;
        $result["password"] = $hashed_password;

        try {
            $this->validate->validator($result);
            $user = new User($this->conn);
            $user->register($result);
        } catch (CustomException $exception) {
            echo $exception->getMessage() . $exception->getCode();
            foreach ($exception->getTheError() as $errorTitle => $errorMessage) {
                echo $errorMessage;
            }
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo "something went wrong while logging in";
        } else {
            echo "hi";
            $email = $_POST["email"];
            $password = $_POST["password"];
            $user = new User($this->conn);
            $user->login($email, $password);
        }
    }

    public function insertCsv(string $path)
    {
        echo "controller";
        $csv = new User($this->conn);
        if ($csv->insertFromCsv($path)) {
            echo "successfully inserted";
        }
    }
}
