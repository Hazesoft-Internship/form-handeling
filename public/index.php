<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
require_once("../src/config.php");

use ayushtamang\FormHandeling\model\Authentication;
use ayushtamang\FormHandeling\control\Sanitizer;


$upload = new Authentication($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fn = Sanitizer::sanitizeString($_POST["firstname"]);
    $mn = Sanitizer::sanitizeString($_POST["middlename"]);
    $ln = Sanitizer::sanitizeString($_POST["lastname"]);
    $add = Sanitizer::sanitizeString($_POST["address"]);
    $em = Sanitizer::sanitizeEmail($_POST["email"]);
    $pw = Sanitizer::sanitizePassword($_POST["password"]);
    
    try {
        if($upload->register($fn, $mn, $ln, $add, $em, $pw)) {
            header("Location: ../src/view/login.php");
        } else {
            echo "Failed to insert data!";
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getInputValue($name): void 
{
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <script src="../src/control/passwordValidate.js"></script>
</head>
<body>
    <form action="index.php" method="POST" id="registerForm">
        <label>First Name</label>
        <input type="text" name="firstname" placeholder="First Name" value="<?php getInputValue("firstname")?>" autocomplete="off" required>
        <br>
        <label>Middle Name</label>
        <input type="text" name="middlename" placeholder="Middle Name" value="<?php getInputValue("middlename")?>" autocomplete="off">
        <br>
        <label>Last Name</label>
        <input type="text" name="lastname" placeholder="Last Name" value="<?php getInputValue("lastname")?>" autocomplete="off" required>
        <br>
        <label>Address</label>
        <input type="text" name="address" placeholder="Address" value="<?php getInputValue("address")?>" autocomplete="off" required>
        <br>
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email")?>" autocomplete="off" required>
        <br>
        <span id="passwordError"></span>
        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Password" autocomplete="off" required>
        <br>
        <label>Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off" required>
        <br>
        <input type="submit" name="submitButton" value="SUBMIT">
    </form>
    <a href="../src/view/login.php">Already have an account? Sign In Here.</a>
</body>
</html>