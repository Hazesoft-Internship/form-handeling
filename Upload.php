<?php

class Upload 
{    
    private $errorArray = array();
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function insertUserDetails($fn, $mn, $ln, $add, $em): mixed 
    {
        $query = $this->con->prepare("INSERT INTO users (firstName, middleName, lastName, address, email) 
                                    VALUES (?, ?, ?, ?, ?)");
        
        $query->bind_param("sssss", $fn, $mn, $ln, $add, $em);
        
        return $query->execute();
    }

    public function register($fn, $mn, $ln, $add, $em): mixed {
        $this->validateFirstName($fn);
        $this->validateMiddleName($mn);
        $this->validateLastName($ln);
        $this->validateAddress($add);
        $this->validateEmail($em);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $mn, $ln, $add, $em);
        }
        else {
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

    public function getError($error)
    {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span><br>";
        }
    }
}
?>