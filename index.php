<?php
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data Form</title>
</head>


<body>
    <form action="process.php" method="post">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>


        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name"><br><br>


        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>


        <label for="address">Address:</label>
        <input type="text" id="address" name="address" minlength="6" required><br><br>


        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>


        <input type="submit" value="Submit">
    </form>
</body>


</html>
<?php
?>