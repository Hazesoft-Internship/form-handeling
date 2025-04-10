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
    <title>Login</title>
</head>
<body>
    <form action="/loginSubmit" method="POST">
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" value="<?php getInputValue("email")?>" autocomplete="off" required>
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off" required>
        <br>
        <button type="submit" name="submitButton" value="SUBMIT">Login</button>
    </form>
    <a href="/">Dont have an account? Sign Up Here.</a>
    <br>
    <a href="/product">Login as Guest.</a>
</body>
</html>