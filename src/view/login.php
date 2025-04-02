<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require_once("../config.php");

use ayushtamang\FormHandeling\model\Authentication;
use ayushtamang\FormHandeling\control\Sanitizer;
use ayushtamang\FormHandeling\session\Session;


$upload = new Authentication($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $em = Sanitizer::sanitizeEmail($_POST["email"]);
    $pw = Sanitizer::sanitizePassword($_POST["password"]);
    
    try {
        if($upload->login($em, $pw)) {
            Session::setSession("userLoggedIn", $em);
            header("Location: productStore.php");
        } else {
            echo "Failed to login!";
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
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email")?>" autocomplete="off" required>
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off" required>
        <br>
        <button type="submit" name="submitButton" value="SUBMIT">Login</button>
    </form>
    <a href="../../public/index.php">Dont have an account? Sign Up Here.</a>
</body>
</html>