<?php

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
    <script src="../src/controls/passwordValidate.js"></script>
</head>
<body>
    <form action="/registerSubmit" method="POST" id="registerForm">
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
        <span id="passwordError" style="color: red;"></span>
        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Password" autocomplete="off" required>
        <br>
        <label>Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off" required>
        <br>
        <input type="submit" name="submitButton" value="SUBMIT">
    </form>
    <a href="/login">Already have an account? Sign In Here.</a>
</body>
</html>