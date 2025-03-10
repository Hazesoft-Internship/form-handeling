<?php

require_once "connection.php";

// For showing errors
$fnameErr = "";
$mnameErr = "";
$lnameErr = "";
$addressErr = "";
$emailErr = "";

// For storing user's data
$fname = "";
$mname = "";
$lname = "";
$address = "";
$email = "";

// Input fields validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validating first name
    if (empty($_POST["fname"])) {
        $fnameErr = "First Name is required";
    } else {
        $fname = input_data($_POST["fname"]);

        // to check first name only contains alphabets
        if (!preg_match("/^[a-zA-Z]+$/", $fname)) {
            $fnameErr = "Only alphabets are allowed as First Name";
        }
    }

    // validating middle name
    if (!empty($_POST["mname"])) {
        $mname = input_data($_POST["mname"]);
        // to check middle name only contains alphabets
        if (!preg_match("/^[a-zA-Z\s]+$/", $mname)) {
            $mnameErr = "Only alphabets are allowed as Middle Name";
        }
    }

    // validating last name
    if (empty($_POST["lname"])) {
        $lnameErr = "Last Name is required";
    } else {
        $lname = input_data($_POST["lname"]);

        // to check last name only contains alphabets
        if (!preg_match("/^[a-zA-Z]+$/", $lname)) {
            $lnameErr = "Only alphabets are allowed as Last Name";
        }
    }

    // validating address
    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = input_data($_POST["address"]);

        // regex for address
        if (!preg_match("/./", $address)) {
            $addressErr = "Please provide a valid address";
        }
    }

    // validating email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = input_data($_POST["email"]);

        // to check email format
        if (!preg_match("/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z\d\.]{2,}$/", $email)) {
            $emailErr = "Please provide a correct email";
        }
    }

    $sql_insertform = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`) VALUES ('$fname', '$mname', '$lname', '$address', '$email')";

    // if ($fnameErr == "" && $mnameErr == "" && $lnameErr == "" && $addressErr == "" && $emailErr == "") {
    // }
    $result = mysqli_query($conn, $sql_insertform);
}
