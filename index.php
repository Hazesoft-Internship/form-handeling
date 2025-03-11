<?php

require_once("config.php");
require_once("classes/Upload.php");
require_once("classes/Sanitizer.php");
require_once("classes/ErrorMessage.php");

$upload = new Upload($con);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fn = Sanitizer::sanitizeString($_POST["firstname"]);
    $mn = Sanitizer::sanitizeString($_POST["middlename"]);
    $ln = Sanitizer::sanitizeString($_POST["lastname"]);
    $add = Sanitizer::sanitizeString($_POST["address"]);
    $em = Sanitizer::sanitizeEmail($_POST["email"]);
    $pw = Sanitizer::sanitizePassword($_POST["password"]);
    $pw2 = Sanitizer::sanitizePassword($_POST["password2"]);
    
    if($upload->register($fn, $mn, $ln, $add, $em, $pw, $pw2)) {
        $_SESSION["userLoggedIn"] = $em;
        header("Location: login.php");
    } else {
        echo "Failed to insert data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <form action="index.php" method="POST">
        <?php echo $upload->getError(ErrorMessage::$firstNameCharacters); ?>
        <label>First Name</label>
        <input type="text" name="firstname" placeholder="First Name" autocomplete="off" required>
        <br>
        <?php echo $upload->getError(ErrorMessage::$middleNameCharacters); ?>
        <label>Middle Name</label>
        <input type="text" name="middlename" placeholder="Middle Name" autocomplete="off">
        <br>
        <?php echo $upload->getError(ErrorMessage::$lastNameCharacters); ?>
        <label>Last Name</label>
        <input type="text" name="lastname" placeholder="Last Name" autocomplete="off" required>
        <br>
        <?php echo $upload->getError(ErrorMessage::$addressCharacters); ?>
        <label>Address</label>
        <input type="text" name="address" placeholder="Address" autocomplete="off" required>
        <br>
        <?php echo $upload->getError(ErrorMessage::$emailInvalid); ?>
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" autocomplete="off" required>
        <br>
        <?php echo $upload->getError(ErrorMessage::$passwordsDoNotMatch); ?>
        <?php echo $upload->getError(ErrorMessage::$passwordNotAlphanumeric); ?>
        <?php echo $upload->getError(ErrorMessage::$passwordLength); ?>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off" required>
        <br>
        <label>Confirm Password</label>
        <input type="password" name="password2" placeholder="Confirm Password" autocomplete="off" required>
        <br>
        <input type="submit" name="submitButton" value="SUBMIT">
    </form>
    <a href="login.php">Already have an account? Sign In Here.</a>
</body>
</html>