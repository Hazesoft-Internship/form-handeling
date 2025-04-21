
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
                    <input type="text" value="<?php echo $userCartItem["purchase_quantity"] ?>" class="quantity"/> 
                    <p onclick="minus(this)">-</p>
                    <p>product price: </p>
                    <p class="price" data-price="<?= $userCartItem["product_price"] ?>"><?php echo $userCartItem["price"] ?></p>
                        <button type="button" onclick="deleteCartItem(<?= $userCartItem['cart_item_id'] ?>)">delete from cart</button>
                </div>
            </div>
            <input type="hidden" class="quantity" name="items[<?= $index ?>][purchase_quantity]" value="<?php echo $userCartItem["purchase_quantity"] ?>" />
            <input type="hidden" name="items[<?= $index ?>][product_id]" value="<?php echo $userCartItem["product_id"] ?>" />
        <?php endforeach; ?>
        <button type="submit">checkout</button>
    </form>
    <a href="/product"><button>back to product page</button></a>
    
    <script>
        const add = (element) => {
    parentElement = element.parentElement;
    priceElement = parentElement.querySelector(".price")
    quantityElement = parentElement.querySelector(`.quantity`);
    index = parentElement.dataset.index;
    price = parseInt(priceElement.dataset.price);
    quantity = parseInt(quantityElement.value)
    stock = parseInt(parentElement.dataset.stock);
    if (quantity < stock) {
        quantity += 1
        quantityElement.value = quantity;
        priceElement.textContent = price * quantity
        hiddenQuantityInput = document.querySelector(`input[name="items[${index}][purchase_quantity]"]`)

        if (hiddenQuantityInput) {
            hiddenQuantityInput.value = quantity
        }
    }
}

const minus = (element) => {
    parentElement = element.parentElement;
    priceElement = parentElement.querySelector(".price")
    quantityElement = parentElement.querySelector(".quantity");
    index = parentElement.dataset.index;
    price = parseInt(priceElement.dataset.price);
    quantity = parseInt(quantityElement.value);
    if (quantity > 1) {
        quantity -= 1
        quantityElement.value = quantity;
        priceElement.textContent = price * quantity
        hiddenQuantityInput = document.querySelector(`input[name="items[${index}][purchase_quantity]"]`)
        quantityElement.textContent = quantity;

        if (hiddenQuantityInput) {
            hiddenQuantityInput.value = quantity
        }
    }
}

function deleteCartItem (cartItemId) {
    const form = document.createElement("form")
    form.action = "/deleteCart"
    form.method = "POST"
    const input = document.createElement("input")
    input.type = "hidden"
    input.name = "cartItemId"
    input.value = cartItemId
    form.appendChild(input)
    document.body.appendChild(form)
    form.submit()
}

document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('input', (event) => {
        const quantityInput = event.target;
        const parentElement = quantityInput.parentElement;
        const index = parentElement.dataset.index;
        const stock = parseInt(parentElement.dataset.stock);
        const priceElement = parentElement.querySelector('.price');
        const price = parseInt(priceElement.dataset.price);
        
        let quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity;
        priceElement.textContent = price * quantity;

        const hiddenQuantityInput = document.querySelector(`input[name="items[${index}][purchase_quantity]"]`);
        if (hiddenQuantityInput) {
            hiddenQuantityInput.value = quantity;
        }
    });
});


    </script>
</body>

</html>