<?php

use Lattefront\FormHandeling\session\Session;   

// Check if the user is logged in, 

if ( Session::getInstance()->isLoggedIn()) {
    header("Location: /dashboard");
    exit();
}
?>

<html>
<meta name="viewport" content="width=device-width">

<head>
    <title> signupform</title>
</head>

<body>
    <form action="/signup" method="POST">
        <label for="First_name"> First Name</label>
        <input type="text" id="First_name" name="First_name" required><br><br>

        <label for="Middle_name"> Middle Name</label>
        <input type="text" id="Middle_name" name="Middle_name"><br><br>

        <label for="Last_name"> Last Name</label>
        <input type="text" id="Last_name" name="Last_name" required><br><br>

        <label for="Email"> Email</label>
        <input type="text" id="Email" name="Email" required><br><br>

        <label for="Password"> Password</label>
        <input type="password" id="Password" name="Password" required><br><br>

        <label for="Address">Address</label>
        <input type="text" id="Address" name="Address" required><br><br>

        <input type="submit" value="Signup">
        <input type="reset" value="Reset">
        <br><br>
        <small>already signup?<a href="/login">login</a> </small>
    </form>
</body>

</html>