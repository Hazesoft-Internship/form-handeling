<?php

namespace Validation;

require_once 'connection.php';

use Database\Connection;

$connection = new Connection('mysql', 'user', 'password', 'mydb');

$conn = $connection->connect();

class Formvalidation extends Connection
{
    public $fname='';
    public $mname='';
    public $lname='';
    public $address='';
    public $email='';
    public $fnameErr='';
    public $mnameErr='';
    public $lnameErr='';
    public $addressErr='';
    public $emailErr='';

    public function __construct($servername, $username, $password, $dbname)
    {
        parent::__construct($servername, $username, $password, $dbname);
    }
    public function getFormData()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // validating first name
            if (empty($_POST["fname"])) {
                $this->fnameErr = "First Name is required";
            } else {
                $this->fname = $this->input_data($_POST["fname"]);

                // to check first name only contains alphabets
                if (!preg_match("/^[a-zA-Z]+$/", $this->fname)) {
                    $this->fnameErr = "Only alphabets are allowed as First Name";
                }
            }

            // validating middle name
            if (!empty($_POST["mname"])) {
                $this->mname = $this->input_data($_POST["mname"]);
                // to check middle name only contains alphabets
                if (!preg_match("/^[a-zA-Z\s]+$/", $this->mname)) {
                    $this->mnameErr = "Only alphabets are allowed as Middle Name";
                }
            }

            // validating last name
            if (empty($_POST["lname"])) {
                $this->lnameErr = "Last Name is required";
            } else {
                $this->lname = $this->input_data($_POST["lname"]);

                // to check last name only contains alphabets
                if (!preg_match("/^[a-zA-Z]+$/", $this->lname)) {
                    $this->lnameErr = "Only alphabets are allowed as Last Name";
                }
            }

            // validating address
            if (empty($_POST["address"])) {
                $this->addressErr = "Address is required";
            } else {
                $this->address = $this->input_data($_POST["address"]);

                // regex for address
                if (!preg_match("/./", $this->address)) {
                    $this->addressErr = "Please provide a valid address";
                }
            }

            // validating email
            if (empty($_POST["email"])) {
                $this->emailErr = "Email is required";
            } else {
                $this->email = $this->input_data($_POST["email"]);

                // to check email format
                if (!preg_match("/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d\.]{2,}$/", $this->email)) {
                    $this->emailErr = "Please provide a correct email";
                }
            }
        }
    }

    public function insertFormData(){
        global $conn;
        $sql_insertform = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`) VALUES ('$this->fname', '$this->mname', '$this->lname', '$this->address', '$this->email')";

        if ($this->fnameErr == "" && $this->mnameErr == "" && $this->lnameErr == "" && $this->addressErr == "" && $this->emailErr == "") {
            $result = mysqli_query($conn, $sql_insertform);
        }

        $this->disconnect();
    }
}

$form = new Formvalidation('mysql', 'user', 'password', 'mydb');

?>
