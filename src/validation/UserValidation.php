<?php

namespace App\validation;

require_once __DIR__."/../../vendor/autoload.php";

use App\validation\Validation;
use App\connectDB\UploadUser;

class UserValidation extends Validation
{
    private string $firstName = "";
    private string $middleName = "";
    private string $lastName = "";
    private string $email = "";
    private string $address = "";
    private string $password = "";
    private array $error = [];
    private int $i = 0;

    //this function reads the data from the form
    public function read(): void 
    {  
        $this->firstName = htmlspecialchars($this->validate("firstName"));
        $this->middleName = htmlspecialchars($this->validate("middleName"));
        $this->lastName = htmlspecialchars($this->validate("lastName"));
        $this->address = htmlspecialchars($this->validate("address"));
        $this->email = htmlspecialchars($this->validate("email"));
        $this->password = htmlspecialchars($this->validate("password"));
        if(empty($this->error)) {
            echo "empty error";
            $this->upload();
        }
        else {
            echo "<br>error not empty<br>";
            echo "<br>" .var_dump($this->error). "<br>";
        }
    }


    //and creates and user object to upload it to db
    public function validate($fieldName)
    {
            if($fieldName == "email") {
                if(!empty($_POST[$fieldName]) && $this->validateEmail($_POST[$fieldName])) 
                {
                    // echo "<br>validation for $fieldName<Br>";
                    return $_POST[$fieldName];
                }
                else 
                {
                    $this->error[4] = "Error in email";
                    return "";
                }
            }
            else if($fieldName == "password") 
            {
                if(!empty($_POST[$fieldName]) && $this->validatePassword($_POST[$fieldName])) 
                {
                    // echo "<br>validation for $fieldName <br>";
                    return password_hash($_POST[$fieldName], PASSWORD_DEFAULT);
                }
                else 
                {
                    var_dump($_POST[$fieldName]);
                    $this->error[5] = "Error in $fieldName 
                                    atleast one uppper,lowercase, number and special character is required.";
                    return "";
                }
            }
            else 
            {
                if(!empty($_POST[$fieldName]) && $this->validateText($_POST[$fieldName])) 
                {
                    // echo "<br>validation for $fieldName <br>";
                    $this->i++;
                    return $_POST[$fieldName];
                }
                else 
                {
                    $this->error[$this->i] = "Error in $fieldName";
                    return "";
                }
            }
        }
    
    public function upload(): void
    {
    $user1 = new UploadUser();
    $user1->createUser($this->firstName,$this->middleName,$this->lastName,$this->address,$this->email, $this->password);
}
}


    