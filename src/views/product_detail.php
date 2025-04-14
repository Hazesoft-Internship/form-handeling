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

      if (!$isOwnProduct) {
    ?>
        <form id="cartForm" action="/cart/addItems" method="POST" style="display: none;">
          <input type="hidden" name="product_id" value="<?php echo $product['productid']; ?>">
          <input type="number" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" value="1">
          <button type="submit">Add to Cart</button>
        </form>

        <!-- Button to trigger quantity input visibility -->
        <button id="showQuantityBtn">Add to Cart</button>
      <?php
      } else { ?>
        <a href="/product/<?php echo $product['productid'] ?>/update_product">Edit Product</a>
        <!-- Form for deleting the product -->
        <form action="/product/<?php echo $product['productid'] ?>/delete_product" method="POST">
          <!-- Hidden field with the product ID -->
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['productid']) ?>">

          <!-- Confirmation prompt on button click -->
          <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
        </form>
    <?php  }
    } elseif ($productId > 0) {
      echo "<p>Product not found.</p>";
    } else {
      echo "<p>Invalid product ID.</p>";
    }
    ?>
    <script>
      // Get elements
      const showQuantityBtn = document.getElementById('showQuantityBtn');
      const cartForm = document.getElementById('cartForm');

      // Show form and quantity input when "Add to Cart" button is clicked
      showQuantityBtn.addEventListener('click', function() {
        cartForm.style.display = 'block'; // Show the form
        showQuantityBtn.style.display = 'none'; // Hide the original button
      });
    </script>

  </div>
</body>

</html>