<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (!Session::checkLogin()) {
  header("Location: login_form.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Product</title>
</head>

<body>
  <h1>Add a New Product</h1>
  <form action="/add_product" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required><br><br>

    <label for="price">Price:</label>
    <input type="text" name="price" required><br><br>

    <button type="submit">Submit</button>
  </form>
  <br>
  <a href="dashboard.php">Back to Dashboard</a>
</body>

</html>