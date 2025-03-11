
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Handling and Post</title>
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
            left: 47vw;
            margin: 1em;
        }

        .container {
            height: 45vh;
            width: 100vw;
            padding-top: 10vh;
        }

        #upload_10K {
            left : 46.5vw;
        }
    </style>
</head>
<body>
    <h1>This is a form</h1>
        <div class="container">
        <form action="upload.php" method="POST">
        <br>
        <input type="text" name="firstName" id="firstName" placeholder="Enter your first name" required>
        <br>
        <input type="text" name="middleName" id="middleName" placeholder="Enter your middle name">
        <br>
        <input type="text" name="lastName" id="lastName" placeholder="Enter your last name" required>
        <br>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>
        <br>
        <input type="text" name="address" id="address" placeholder="Enter your address" required>
        <br>

        <button type="submit">Submit</button>
        </form>
        </div>

        <form action = "InsertUser.php" method = "POST">
            <button id = "upload_10K">Upload 10K</button>
        </form>
</body>
</html>