<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Products</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 32px;
            margin-bottom: 16px;
        }

        a {
            text-align: center;
            display: block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 32px 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
        }

        .product-card {
            border: 1px solid #eee;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.06);
            padding: 20px;
            width: 320px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-card form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-card label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-card input[type="text"],
        .product-card input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .product-card button {
            margin-top: 5px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .product-card button:hover {
            background-color: #0056b3;
        }

        .product-card h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        @media (max-width: 900px) {
            .product-container {
                flex-direction: column;
                align-items: center;
                padding: 10px;
            }

            .product-card {
                width: 100%;
                max-width: 400px;
            }
        }
    </style>
</head>

<body>
    <h1>Your Products</h1>
    <a href="/add-product">Add New Product</a>
    <div class="product-container">
        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <form action="/update-product" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['product_id']) ?>" />
                        <label for="name">Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" />
                        <label for="description">Description</label>
                        <input type="text" name="description" value="<?= htmlspecialchars($product['description']) ?>" />
                        <label for="price">Price</label>
                        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" min="0" />
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" min="0" />
                        <button type="submit">Update</button>
                    </form>
                    <form action="/delete-product" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['product_id']) ?>" />
                        <button type="submit">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>