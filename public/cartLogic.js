const add = (element) => {
    parentElement = element.parentElement;
    priceElement = parentElement.querySelector(".price")
    quantityElement = parentElement.querySelector(`.quantity`);
    index = parentElement.dataset.index;
    price = parseInt(priceElement.dataset.price);
    quantity = parseInt(quantityElement.textContent)
    stock = parseInt(parentElement.dataset.stock);
    if (quantity < stock) {
        quantity += 1
        quantityElement.textContent = quantity;
        priceElement.textContent = price * quantity
        hiddenQuantityInput = document.querySelector(`input[name="items[${index}][purchase_quantity]"]`)
        hiddenPriceInput = document.querySelector(`input[name="items[${index}][unit_price]"]`)

        if (hiddenQuantityInput) {
            hiddenQuantityInput.value = quantity
            hiddenPriceInput.value = priceElement.textContent
        }
    }
}

const minus = (element) => {
    parentElement = element.parentElement;
    priceElement = parentElement.querySelector(".price")
    quantityElement = parentElement.querySelector(".quantity");
    index = parentElement.dataset.index;
    price = parseInt(priceElement.dataset.price);

    quantity = parseInt(quantityElement.textContent.trim());
    if (quantity > 1) {
        quantity -= 1
        quantityElement.textContent = quantity;
        priceElement.textContent = price * quantity
        hiddenQuantityInput = document.querySelector(`input[name="items[${index}][purchase_quantity]"]`)
        hiddenPriceInput = document.querySelector(`input[name="items[${index}][unit_price]"]`)
        quantityElement.textContent = quantity;

        if (hiddenQuantityInput) {
            hiddenQuantityInput.value = quantity
            hiddenPriceInput.value = priceElement.textContent
        }
    }
}