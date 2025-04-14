<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Cart</h1>
    <form action="/updateCart" method="POST">
        <?php foreach ($userCartItems as $index => $userCartItem): ?>
            <div style="background-color: skyblue; margin: 30px 0px">
                <p>product name: <?php echo $userCartItem["name"] ?></p>
                <p>product quantity:</p>
                <div style="display:flex;gap:20px" data-index="<?= $index ?>" data-stock="<?= $userCartItem["quantity"] ?>">
                    <p onclick="add(this)">+</p>
                    <p class="quantity"> <?php echo $userCartItem["purchase_quantity"] ?></p>
                    <p onclick="minus(this)">-</p>
                    <p>product price: </p>
                    <p class="price" data-price="<?= $userCartItem["price"] ?>"><?php echo $userCartItem["unit_price"] ?></p>
                </div>
            </div>
            <input type="hidden" class="quantity" name="items[<?= $index ?>][purchase_quantity]" value="<?php echo $userCartItem["purchase_quantity"] ?>" />
            <input type="hidden" name="items[<?= $index ?>][unit_price]" value="<?php echo $userCartItem["unit_price"] ?>" />
            <input type="hidden" name="items[<?= $index ?>][product_id]" value="<?php echo $userCartItem["product_id"] ?>" />
        <?php endforeach; ?>
        <button type="submit">checkout</button>
    </form>
    <script src="/cartLogic.js">
    </script>
</body>

</html>