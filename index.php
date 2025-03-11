<!DOCTYPE html>
<html>

<head>
    <title>PHP Form_handeling</title>

    <style>
        body {
            text-align: center;
            background-color: rgb(255, 253, 253);
            padding-top: 100px;
        }

        form {

            width: 25%;
            margin: 0 auto;
            padding: 2px;
            border: 1px solid rgb(0, 0, 0);
            background-color: rgb(250, 250, 250);
        }
    </style>
</head>

<body>

    <form action="db_upload.php" method="post">
        <h1>USER REGISTRATION</h1>
        <lable for="first_name">First name:</lable>
        <input id="first_name" type="text" name="first_name" placeholder="Enter First Name" required><br><br>
        <lable for="middle_name">Middle name:</lable>
        <input id="middle_name" type="text" name="middle_name" placeholder="Enter Middle Name"> <br><br>
        <lable for="last_name">Last name:</lable>
        <input id="last_name" type="text" name="last_name" placeholder="Enter Last Name" required><br><br>
        <lable for="address">Address:</lable>
        <input id="address" type="text" name="address" placeholder="Enter Address" required><br><br>
        <lable for="email">E-mail:</lable>
        <input id="email" type="email" name="email" placeholder="Enter Email" required><br><br>
        <input type="submit" value="Submit">
    </form>

</body>

</html>