<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            text-align: center;
            background-color: black;
            color: white;
        }

        h1 {
            padding-top: 12vh;
        }
        input {
            margin: 5px;
            border-radius: 10px;
            text-align: left;
            height: 40px;
            width: 30%;
            border: 10px double black;
        }

        button {
            text-align: center;
            position: absolute;
            left: 35%;
            margin: 1em;
        }

        #logout {
            left: 60%;
            top: 59%;
        }

        .container {
            height: 45vh;
            width: 100vw;
            padding-top: 5vh;
        }
        #upload_10K {
            left : 46.5vw;
        }

        #signup {
            top: 50%;
            left: 60%;        
        }

        #signuptext {
            position: absolute;
            top: 50%;
            left: 51%;
        }

    </style>
</head>
<body>
    <h1>Welcome, <?php echo "$userName"; ?><br></h1>
    <h2>Update your product : <?php echo strtoupper($product['productName']) ?></h2>
        <div class="container">
        <form action="/updateProduct" method="POST">
        <br>
            <input type='number' required name="updatedPrice" placeholder="Enter updated price of your product"><br>
            <input type='number' required name="updatedQuantity" placeholder="Enter updated quantity of product"><br>
            <input type="hidden" name="id" value = <?php echo $_GET['id']?>>
        <button type="submit" name="submitUpdate">Submit</button>
        </form>
        </div>
</body>
</html>