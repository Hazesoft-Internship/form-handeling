<?php

namespace App\controller;

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("./src/App/validate/Seperator.php");
require_once("./src/App/validate/validation.php");

use App\validate\Seperator;
use App\validate\Validation;
use App\model\User;

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
        $address = $_POST["address"];
        $result = Seperator::seperate($fullName);
        $result["email"] = $email;
        $result["address"] = $address;
        $result["password"] = $password;
        if ($this->validate->validator($result)) {
            $user = new User($this->conn);
            $user->register($result);
        } else {
            foreach($this->validate->getError() as $x=>$y) {
                echo $y;

            }
        }
    }

    public function login()
    {
        echo "hello";
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
}
