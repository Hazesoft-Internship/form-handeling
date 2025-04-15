<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form action="/public/index.php?controller=User&action=login" method="POST">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
