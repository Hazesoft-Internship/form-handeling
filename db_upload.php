<?php

require_once "validation.php";
require_once "db_connection.php";
require_once "sanitization.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST["first_name"];
    $middleName = $_POST["middle_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
}


class dbConnect
{
    private $connection;

    public function __construct(private $database = new Database)
    {
        $this->connection = $this->database->connect();
    }

    public function upload($firstName, $middleName, $lastName, $address, $email)
    {
        //Code validation
        $valid1 = new Validation;
        $valid1->validateName($firstName, $middleName, $lastName);
        $valid1->validateAddress($address);
        $valid1->validateEmail($email);

        //Code sanitization
        $inputObject = new sanitizeInput();
        $userData = $inputObject->getData();
        $firstName = $inputObject->sanitizer($userData[0]);
        $middleName = $inputObject->sanitizer($userData[1]);
        $lastName = $inputObject->sanitizer($userData[2]);
        $address = $inputObject->sanitizer($userData[3]);
        $email = $inputObject->sanitizer($userData[4]);

        mysqli_query($this->connection, "INSERT INTO users(firstName, middleName, lastName, email, address) VALUES ('$firstName', '$middleName', '$lastName', '$email', '$address')");

        echo "Data uploaded successfully!";
    }
}


$db_upload = new dbConnect;
$db_upload->upload($firstName, $middleName, $lastName, $address, $email);
