<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>

    <style>
        .error {
            color: red;
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <form action="users.php" method="POST">

        <label for="fname">First Name</label>
        <input type="text" name="fname" id="fname" value="<?php echo $fName; ?>" required>
        <span class="error"><?php echo $fNameErr; ?></span><br><br>


        <label for="mname">Middle Name</label>
        <input type="text" name="mname" id="mname" value="<?php echo $mName; ?>" required>
        <span class="error"><?php echo $mNameErr; ?></span><br><br>


        <label for="lname">Last Name</label>
        <input type="text" name="lname" id="lname" value="<?php echo $lName; ?>" required>
        <span class="error"><?php echo $lNameErr; ?></span><br><br>


        <label for="address">Address</label>
        <textarea name="address" id="address" required><?php echo $address; ?></textarea>
        <span class="error"><?php echo $addressErr; ?></span><br><br>


        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>
        <span class="error"><?php echo $emailErr; ?></span><br><br>

        <button type="submit">Submit</button>
    </form>
</body>

</html>