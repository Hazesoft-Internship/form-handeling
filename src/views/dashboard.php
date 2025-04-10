<?php

use Hazesoft\Formhandeling\Controllers\ProductController;
use Hazesoft\Formhandeling\Services\Session;

ini_set('display_errors', 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

$session = Session::getInstance();

$session->start();

if (Session::checkLogin()) {
  header("Location: /products");
  exit();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Public Product Listing</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Welcome to the Dashboard</h1>
  <a href="/login">Login</a>
  <a href="/register">Register</a>
  <hr>
  <h2>All Products</h2>

  <div class="product-list">
    <?php

    if (!empty($products)) {
      foreach ($products as $product) {
        echo "<div class='product'>";
        echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
        echo "<p><strong>Quantity:</strong> " . htmlspecialchars($product['quantity']) . "</p>";
        echo "<p><strong>Price:</strong> " . htmlspecialchars($product['price']) . "</p>";
        echo "<p><strong>Created:</strong> " . htmlspecialchars($product['created_at']) . "</p>";
        echo "<p><strong>Updated:</strong> " . htmlspecialchars($product['updated_at']) . "</p>";
        echo "</div>";
      }
    } else {
      echo "<p>No products available.</p>";
    }
    ?>
  </div>
</body>

</html>