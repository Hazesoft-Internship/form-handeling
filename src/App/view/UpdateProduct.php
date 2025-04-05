<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Update Product</h1>
    <form onsubmit="onSubmit(event)" action="/update-product" method="POST">
        <input type="hidden" name="id" value="<?php echo $productId ?>" />
        <label>Product Name</label>
        <input name="name" value="<?php echo $singleProduct["name"] ?>" />
        <label>Product Quantity</label>
        <input name="quantity" value="<?php echo $singleProduct["quantity"] ?>" />
        <label>Product Price</label>
        <input name="price" value="<?php echo $singleProduct["price"] ?>" />
        <button type="submit">update</button>
    </form>
    <script>
        const onSubmit = (e) => {
            if (!confirm("Do you really want to update?")) {
                e.preventDefault()
            }
        }
    </script>
</body>
</html>