<?php

require_once "upload.php";
require_once "User.php";

class Validation {
    private $firstName = "";
    private $middleName = "";
    private $lastName = "";
    private $email = "";
    private $address = "";
    private $error = [];
    private $i = 0;

    //this is for the validation of text.
    public function validateText($data): bool
    {
        $pattern = "/^[a-zA-Z0-9]+$/";
        return preg_match($pattern, $data);
    }
    // for the validation of mail address.
    public function validateEmail($email1): bool
    {
        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        return preg_match($pattern, $email1);
    }

    //this function reads the data from the form
    public function read() {
        $this->firstName = htmlspecialchars($this->validate("firstName"));
        $this->middleName = htmlspecialchars($this->validate("middleName"));
        $this->lastName = htmlspecialchars($this->validate("lastName"));
        $this->address = htmlspecialchars($this->validate("address"));
        $this->email = htmlspecialchars($this->validate("email"));
        echo "the first name is : ".$this->firstName;
        $this->upload();
    }


    //and creates and user object to upload it to db
    public function validate($fieldName): string
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            //validation for data entered.
            echo "hello";

            if($fieldName == "email") {
                if(!empty($_POST[$fieldName]) && $this->validateEmail($_POST[$fieldName])) {
                    echo "<br>validation for email<Br>";
                    return $_POST['email'];
                }
                else {
                    $this->error[4] = "Error in email";
                    return NULL;
                }
            }
            else {
                if(!empty($_POST[$fieldName]) && $this->validateText($_POST[$fieldName])) {
                    echo "<br>validation for $fieldName <br>";
                    $this->i++;
                    return $_POST[$fieldName];
                }
                else {
                    $this->error[$this->i] = "Error in $fieldName";
                    return NULL;
                }
            }
        }
    }
    public function upload() {
    $user1 = new User;
    $user1->createUser($this->firstName,$this->middleName,$this->lastName,$this->address,$this->email);
}
}

    $validate1 = new Validation;
    $validate1->read();
