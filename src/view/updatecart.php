
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update Form</title>
</head>

<body>
    <h1>update cart</h1>
    <form action="/updatecart" method="POST">
        <label>Cartitems id</label>
        <input type="text" id="cartitemsId" name="cartitemsId" value="<?php echo htmlspecialchars($cart_itemsId); ?>" readonly>
        <label>Product id</label>
        <input type="text" id="productID" name="productID" value="<?php echo htmlspecialchars($productId); ?>" readonly>
        <br><br>
        <label>Quantity</label>
        <input type="text" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" >
        <br><br>      
        

        <button type="submit">Update Cart</button>
        <input type="reset" value="Reset">
    </form>
</body>

</html>