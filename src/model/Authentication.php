<?php

namespace ayushtamang\FormHandeling\model;

use ayushtamang\FormHandeling\control\Validation;
use ayushtamang\FormHandeling\session\Session;

class Authentication extends Validation
{    
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function insertUserDetails($fn, $mn, $ln, $add, $em, $pw): mixed 
    {
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("INSERT INTO users (firstName, middleName, lastName, address, email, password) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
        
        $query->bind_param("ssssss", $fn, $mn, $ln, $add, $em, $pw);
        
        return $query->execute();
    }

    public function register($fn, $mn, $ln, $add, $em, $pw): mixed 
    {
        try {
            $this->validateString($fn, "First Name");
            $this->validateString($mn, "Middle Name");
            $this->validateString($ln, "Last Name");
            $this->validateString($add, "Address");
            $this->validateEmail($em);
            
            //Unique Email
            $query = $this->con->prepare("SELECT * FROM users WHERE email = ?");
            $query->bind_param("s", $em);
            $query->execute();
            $result = $query->get_result();

            if($result->num_rows != 0) {
                throw new \Exception("Email already exists.");
            }

            if(empty($this->errorArray)) {
                return $this->insertUserDetails($fn, $mn, $ln, $add, $em, $pw);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception("Registration failed: " . $e->getMessage());
        }
    }

    public function login($em, $pw)
    {
        //Check if user exist
        $query = $this->con->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $em);
        $query->execute();
        $result = $query->get_result();

        if($result->num_rows == 0) {
            throw new \Exception("User not found.");
        }

        //Check if input is correct
        $pw = hash("sha512", $pw);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $query->bind_param("ss", $em, $pw);
        $query->execute();
        $result = $query->get_result();

        if($result->num_rows == 1) {
            $result = $result->fetch_assoc();
            Session::setSession("userId", $result['id']);
            return true;
        } else {
            throw new \Exception("Invalid email or password.");
        }
    }
}
?>