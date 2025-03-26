<?php

use HazeSoft\Backend\formHandeling\models\User;

$user = new User();
$loginValidation = new ValidateLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $userArr = array($email, $password);
    $sanitizedUserInput = $loginValidation->validateUserInput($userArr);

    if (isset($sanitizedUserInput["error"])) {
        $errorMessage = $sanitizedUserInput["error"];
        var_dump($errorMessage);
    } else {
        $user->loginUser($sanitizedUserInput[0], $sanitizedUserInput[1]);
    };
}
