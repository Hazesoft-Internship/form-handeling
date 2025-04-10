<?php

namespace ayushtamang\FormHandeling\model;

use ayushtamang\FormHandeling\controls\Validation;
use ayushtamang\FormHandeling\session\Session;

class Authentication extends Validation
{    
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function insertUserDetails($firstName, $middleName, $lastName, $address, $email, $password): mixed 
    {
        $password = hash("sha512", $password);

        $query = $this->con->prepare("INSERT INTO users (firstName, middleName, lastName, address, email, password) 
                                    VALUES (:fn, :mn, :ln, :add, :em, :pw)");
        $query->bindParam(":fn", $firstName);
        $query->bindParam(":mn", $middleName);
        $query->bindParam(":ln", $lastName);
        $query->bindParam(":add", $address);
        $query->bindParam(":em", $email);
        $query->bindParam(":pw", $password);
        
        return $query->execute();
    }

    public function register($firstName, $middleName, $lastName, $address, $email, $password): mixed 
    {
        try {
            $this->validateString($firstName, "First Name");
            $this->validateString($middleName, "Middle Name");
            $this->validateString($lastName, "Last Name");
            $this->validateString($address, "Address");
            $this->validateEmail($email);
            
            //Unique Email
            $query = $this->con->prepare("SELECT * FROM users WHERE email = :em");
            $query->bindParam(":em", $email);
            $query->execute();

            if($query->rowCount() != 0) {
                throw new \PDOException("Email already exists.");
            }

            if(empty($this->errorArray)) {
                return $this->insertUserDetails($firstName, $middleName, $lastName, $address, $email, $password);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new \PDOException("Registration failed: " . $e->getMessage());
        }
    }

    public function login($email, $password)
    {
        $session = Session::getInstance();
        
        //Check if user exist
        $query = $this->con->prepare("SELECT * FROM users WHERE email = :em");
        $query->bindParam(":em", $email);
        $query->execute();
        
        if($query->rowCount() == 0) {
            throw new \PDOException("User not found.");
        }
        
        //Check if input is correct
        $password = hash("sha512", $password);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE email = :em AND password = :pw");
        $query->bindParam(":em", $email);
        $query->bindParam(":pw", $password);
        $query->execute();

        if($query->rowCount() == 1) {
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $session->setSession("userId", $result['id']);
            return true;
        } else {
            throw new \PDOException("Invalid email or password.");
        }
    }
}
?>