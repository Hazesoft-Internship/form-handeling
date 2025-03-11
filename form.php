
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d5f3ee;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 8px 0 4px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <form action="user.php" method="POST">
        <h1> Form</h1>
        
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname" required>

        <label for="Middlename">Middle Name</label>
        <input type="text" name="Middlename" id="Middlename" >   

        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" required>

        <label for="address">Address</label>
        <input type="text" name="address" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>