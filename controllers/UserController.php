<?php


require_once '../models/User.php';

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user->registerUser($fullName, $email, $password);
        header("Location: /product-store ");
    } else if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user->loginUser($email, $password);
    } else if (isset($_POST['logout'])){
        $user->logOutUser();
    }
}
