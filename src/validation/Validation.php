<?php

namespace App\validation;

require_once __DIR__."/../../vendor/autoload.php";

use App\Model\Database;

abstract class Validation
{
    public $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    public function validateText($data): bool
    {
        $pattern = "/^[a-zA-Z0-9]+$/";
        return preg_match($pattern, $data);
    }

    public function validateEmail($email1): bool
    {
        $query = "SELECT * FROM users WHERE email='$email1'";
        $result = $this->conn->query($query);
        if($result->fetchAll())
        {
            echo "the email : '" .$email1 ."' is aldready in registered";
            die();
        }

        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        return preg_match($pattern, $email1);
    }

    public function validatePassword($pass): bool
    {
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        return preg_match($pattern, $pass);
    }

    abstract public function read();
    abstract public function validate($fieldName);
    abstract public function upload();
}
