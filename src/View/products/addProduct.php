
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
    <h2>Add your product</h2>
        <div class="container">
        <form action="/addProduct" method="POST">
        <br>
            <input type='text' required name="productName" placeholder="Enter name of you product"><br>
            <input type='number' required name="quantity" placeholder="Enter quantity of product"><br>
            <input type='number' required name="price" placeholder="Enter the price of your product"><br>
            <button type="submit">Submit</button>
        </form>
        <form action = "/logout" method = "POST">
            <button type="submit" name="logout" id="logout">Log-Out</button>
        </form>
        </div>

        <?php
            if(isset($_POST["logout"])) 
            {
                session::getInstance()->set("isLoggedIn", FALSE);
                header("/login");
            }
        ?>
</body>
</html>