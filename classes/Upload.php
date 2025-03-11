<?php

class Upload 
{    
    private $errorArray = array(), $check;
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function insertUserDetails($fn, $mn, $ln, $add, $em, $pw): mixed 
    {
        $query = $this->con->prepare("INSERT INTO users (firstName, middleName, lastName, address, email, password) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
        
        $query->bind_param("ssssss", $fn, $mn, $ln, $add, $em, $pw);
        
        return $query->execute();
    }

    public function register($fn, $mn, $ln, $add, $em, $pw, $pw2): mixed 
    {
        $this->validateFirstName($fn);
        $this->validateMiddleName($mn);
        $this->validateLastName($ln);
        $this->validateAddress($add);
        $this->validateEmail($em);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $mn, $ln, $add, $em, $pw);
        }
        else {
            return false;
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
            array_push($this->errorArray, ErrorMessage::$userNotFound);
            return false;
        }

        //Check if input is correct
        $query = $this->con->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $query->bind_param("ss", $em, $pw);
        $query->execute();
        $result = $query->get_result();

        if($result->num_rows == 1) {
            return true;
        } else {
            array_push($this->errorArray, ErrorMessage::$loginFailed);
            return false;
        }
    }

    public function validateFirstName($fn)
    {
        if(strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, ErrorMessage::$firstNameCharacters);
            return;
        }
    }

    public function validateMiddleName($mn) 
    {
        if(strlen($mn) < 2 || strlen($mn) > 25) {
            array_push($this->errorArray, ErrorMessage::$middleNameCharacters);
            return;
        }
    }

    public function validateLastName($ln)
    {
        if(strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, ErrorMessage::$lastNameCharacters);
            return;
        }
    }

    public function validateAddress($add)
    {
        if(strlen($add) < 2 || strlen($add) > 25) {
            array_push($this->errorArray, ErrorMessage::$addressCharacters);
            return;
        }
    }

    public function validateEmail($em)
    {
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, ErrorMessage::$emailInvalid);
            return;
        }
    }

    private function validatePasswords($pw, $pw2) 
    {
        if($pw != $pw2) {
            array_push($this->errorArray, ErrorMessage::$passwordsDoNotMatch);
            return ;
        }
        
        if(preg_match("/[^A-Za-z0-9]/", $pw)) {
            array_push($this->errorArray, ErrorMessage::$passwordNotAlphanumeric);
            return ;
        }

        if(strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, ErrorMessage::$passwordLength);
        }
    }

    public function getError($error)
    {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span><br>";
        }
    }

    public function addProduct($ui, $pn, $pp, $pq) 
    {
        $query = $this->con->prepare("INSERT INTO products (userId, productName, productPrice, productQuantity) 
                                    VALUES (?, ?, ?, ?)");
        $query->bind_param("isdi", $ui, $pn, $pp, $pq);
        
        return $query->execute();
    }
}
?>