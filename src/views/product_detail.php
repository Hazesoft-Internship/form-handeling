<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

if (!Session::checkLogin()) {
  header("Location: /login");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Detail<?php echo $product ? ' - ' . htmlspecialchars($product['name']) : ''; ?></title>
</head>

<body>
  <h1>Product Detail</h1>
  <a href="/my_products">Back to My Products</a> |
  <a href="../Controllers/Logout.php">Logout</a>

  <div class="product-details">
    <?php
    if ($product) {
      echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
      echo "<p><strong>Price:</strong> $" . htmlspecialchars($product['price']) . "</p>";
      echo "<p><strong>Quantity:</strong> " . htmlspecialchars($product['quantity']) . "</p>";
      echo "<p><strong>Created:</strong> " . htmlspecialchars($product['created_at']) . "</p>";
      echo "<p><strong>Updated:</strong> " . htmlspecialchars($product['updated_at']) . "</p>";
    } elseif ($productId > 0) {
      echo "<p>Product not found.</p>";
    } else {
      echo "<p>Invalid product ID.</p>";
    }

    ?>
    <a href="/product/<?php echo $product['productid'] ?>/update_product">Edit Product</a>
    <!-- Form for deleting the product -->
    <form action="/product/<?php echo $product['productid'] ?>/delete_product" method="POST">
      <!-- Hidden field with the product ID -->
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['productid']) ?>">

      <!-- Confirmation prompt on button click -->
      <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
    </form>
  </div>
</body>

</html>