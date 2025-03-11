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

    <a href="./add_product.php">Add product</a>
    <a href="../controllers/logout.php">Logout</a>
</body>

</html>