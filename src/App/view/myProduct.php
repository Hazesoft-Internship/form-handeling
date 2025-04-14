<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
</head>

<body>
    <div class="product">
        <h1 class="heading">Product List</h1>
        <?php if (!empty($formattedProduct)): ?>
            <div class="container">
                <?php foreach ($formattedProduct as $product): ?>
                    <div class="products">
                        <strong>Name:</strong> <?php echo $product['name']; ?>
                        <strong>Quantity:</strong> <?php echo $product['quantity']; ?>
                        <strong>Price:</strong> $<?php echo $product['price']; ?>
                        <strong>added on:</strong> <?php echo $product['created_at']; ?>
                        <strong>Last updated on:</strong> <?php echo $product['updated_at']; ?>
                    </div>
                    <?php if ($id === $product["user_id"]): ?>
                        <div class="button">
                            <form onsubmit="onSubmit(event)" action="/delete-product" method="POST">
                                <input name="id" type="hidden" value="<?php echo $product["id"] ?>" />
                                <button id="delete" type="submit">delete</button>
                            </form>

                            <a href="/UpdateProduct?id=<?php echo $product["id"] ?>"><button>update</button></a>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
        <a href="/add-product">
            <button>add product</button> </a>
        <a href="/product"><button>back</button></a>



</body>
<script>
    const onSubmit = (e) => {
        if (!confirm("Do you really want to delete?")) {
            e.preventDefault();
        }
    }
</script>

</html>