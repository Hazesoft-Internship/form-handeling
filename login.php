<?php

require_once("config.php");
require_once("classes/Upload.php");
require_once("classes/Sanitizer.php");
require_once("classes/ErrorMessage.php");

$upload = new Upload($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $em = Sanitizer::sanitizeEmail($_POST["email"]);
    $pw = Sanitizer::sanitizePassword($_POST["password"]);
    
    if($upload->login($em, $pw)) {
        $_SESSION["userLoggedIn"] = $em;
        header("Location: product/productStore.php");
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
        <?php echo $upload->getError(ErrorMessage::$userNotFound); ?>
        <?php echo $upload->getError(ErrorMessage::$loginFailed); ?>
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" autocomplete="off" required>
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off" required>
        <br>
        <button type="submit" name="submitButton" value="SUBMIT">Login</button>
    </form>
    <a href="index.php">Dont have an account? Sign Up Here.</a>
</body>
</html>