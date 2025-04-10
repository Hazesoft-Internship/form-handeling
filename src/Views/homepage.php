<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xStore</title>
    <link rel="stylesheet" href="../styles/global.css" />
</head>
<body>
<div class="nav">
    <h1>Welcome to xStore
        <?php if ($session->hasSession("isLoggedIn")): ?>
            , <?= $session->getSession("firstName") ?>
        <?php endif; ?>
    </h1>

    <nav>
        <ul class="nav-elements">
            <li class="nav">
                <a href="/">Home</a>
            </li>
            <li>
                <a href="/products">Products</a>
            </li>
            <?php if (!$session->hasSession("isLoggedIn")): ?>
                <li>
                    <a href="/login">Sign In</a>
                </li>
                <li>
                    <a href="/signup">Sign Up</a>
                </li>
            <?php else: ?>
                <li>
                    <form action="/logout" method="POST">
                        <button type="submit" onclick="return confirm('Are you sure you want to Logout?');">Logout</button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php if ($isLoggedIn): ?>
    <div>
        <h3>My Products</h3>
    </div>
    <div class="products">
        <?php foreach ($myProducts as $product): ?>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['quantity'] ?></td>
                </tr>
                </tbody>
            </table>
            <br>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div>
        <h3>All Products</h3>
    </div>
    <div class="products">
        <?php foreach ($allProducts as $product): ?>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= $product['quantity'] ?></td>
                </tr>
                </tbody>
            </table>
            <br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</body>
</html>