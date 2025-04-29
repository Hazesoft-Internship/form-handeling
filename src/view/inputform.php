<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
</head>
<body>
    <h1>Delete Product</h1>
    <form action="/deleteproduct" method="POST">
        <label for="id">Product ID:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Delete</button>
    </form>
</body>
</html>