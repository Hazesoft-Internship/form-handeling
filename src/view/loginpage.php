<?php

session_start();


// Check if the user is logged in, 
if (isset($_SESSION['email'])) {
    header("Location: /dashboard");
    exit();
}
?>
<html>
<meta name="viewport" content="width=device-width">

<head>
    <title> loginform</title>
</head>

<body>
    <form action="/login" method="POST">
        <label for="Email"> Email</label>
        <input type="Email" id="Email" name="Email" required><br><br>

        <label for="Password"> Password</label>
        <input type="password" id="Password" name="Password" required><br><br>


        <input type="submit" value="Login">
        <input type="reset" value="Reset">
        <br><br>
        <small>not signup?<a href="/signup">Signup</a> </small>
    </form>
</body>

</html>