<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body
        {
            background-color: black;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1
        {
            position: absolute;
            top: 18vh;
        }
        h2
        {
            position: absolute;
            top: 12vh;
        }
        .button-container
        {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .button
        {
            background-color: white;
            color: black;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }
        .button:hover
        {
            background-color: grey;
            transition: 0.5s;
        }
    </style>
</head>
<body>
    <h1>What would you like to do ?</h1>
    <br>
    <h2>Welcome, <?php echo "$userName";?></h2>
    <div class="button-container">
        <form action="/addProduct">
            <button class="button">Add Product</button>
        </form>
        <form action="/viewAllProduct" method="GET">
            <button class="button">All Product</button>
        </form>
        <form action="/viewYourProduct" method="POST">
            <button class="button">Your Product</button>
        </form>
        <form action="/viewYourCart" method="POST">
            <button class="button">Your Carts</button>
        </form>
    </div>
</body>
</html>