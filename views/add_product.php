<?php

require_once __DIR__ . '/../config/session.php';

if (!isset($_SESSION['id'])) {
    header("Location: login_form.php");
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
    <form action="../controllers/product.php" method="POST">

        <label for="name">Name</label>
        <input type="text" name="name" required>

        <label for="name">Quantity</label>
        <input type="text" name="quantity" required>

        <label for="price">Price</label>
        <input type="text" name="price" required>

        <button type="submit">submit</button>

    </form>
</body>

</html>