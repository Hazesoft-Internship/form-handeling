<?php
require_once __DIR__ . '/../config/session.php';

if (isset($_SESSION['id'])) {
    header("Location: products.php");
    exit();
}
?>

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

        .success {
            color: green;
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <form action="../controllers/register.php" method="POST">

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

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <span id="passwordMessage" class="error"></span><br><br>

        <button type="submit" id="submitBtn">Submit</button>
    </form>

    <script src="../public/script.js"></script>
</body>

</html>