<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (Session::checkLogin()) {
    header("Location: products.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    if ($error !== '') {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="/login" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <button type="submit">submit</button>
    </form>
</body>

</html>