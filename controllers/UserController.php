<?php

require_once '../models/User.php';
require_once '../utils/validation.php';

use HazeSoft\Backend\formHandeling\models\User;

$user = new User();
$signupValidation = new ValidateSignup();
$loginValidation = new ValidateLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["register"])) {
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $userArr = array($fullName, $email, $password);
        $sanitizedUserInput = $signupValidation->validateUserInput($userArr);
        print_r($sanitizedUserInput);
        $user->registerUser($sanitizedUserInput[0], $sanitizedUserInput[1], $sanitizedUserInput[2]);
        header("Location: /product-store ");
    } else if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $userArr = array($email, $password);

        $sanitizedUserInput = $loginValidation->validateUserInput($userArr);
        $user->loginUser($sanitizedUserInput[0], $sanitizedUserInput[1]);
    } else if (isset($_POST['logout'])) {
        $user->logOutUser();
    }
}
