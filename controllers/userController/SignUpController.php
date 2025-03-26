<?php

require_once 'formHandeling/utils/validation/ValidateSignup.php';
require_once 'formHandeling/models/User.php';

use HazeSoft\Backend\formHandeling\models\User;

$user = new User();
$signupValidation = new ValidateSignup();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {

    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $userArr = array($fullName, $email, $password);
    $sanitizedUserInput = $signupValidation->validateUserInput($userArr);

    if (isset($sanitizedUserInput["error"])) {
        $errorMessage = $sanitizedUserInput["error"];
        var_dump($errorMessage);

    } else {
        $user->registerUser($sanitizedUserInput[0], $sanitizedUserInput[1], $sanitizedUserInput[2]);
        header("Location: /product-store");
    }
    
};
