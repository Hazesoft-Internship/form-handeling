<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products</title>
</head>

<body>
  <h3>Add Product</h3>
  <form action="/add-product" method="POST">
    <label>Product Name:</label>
    <input type="text" name="name" required /><br />

    <label>Product Quantity:</label>
    <input type="number" name="quantity" required /><br />

    <label>Product Price:</label>
    <input type="number" name="price" required /><br />

    <button type="submit">Add</button>
  </form>

  <a href="/logout"><button>Logout</button></a>
</body>

</html>