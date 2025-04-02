<html>
<meta name="viewport" content="width=device-width">

<head>
    <title> loginform</title>
</head>
<body>
    <form action="./module/login.php" method="POST">
        <label for="Email"> Email</label>
        <input type="text" id="Email" name="Email" required><br><br>

        <label for="Password"> Password</label>
        <input type="password" id="Password" name="Password" required><br><br>

        
        <input type="submit" value="Login">
        <input type="reset" value="Reset">
        <br><br>
        <small>not signup?<a href="./index.php">signup</a> </small>
    </form>
</body>

</html>