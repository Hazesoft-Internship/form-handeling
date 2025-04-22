<?php

use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();
$session->start();

if (Session::checkLogin()) {
    header("Location: /products");
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
    <?php if (!empty($errors)): ?>
        <div class="error"><?= htmlspecialchars($errors) ?></div>
        <br>
    <?php endif; ?>

    <form action="/register" method="POST" id="userForm">
        <label for="fname">First Name</label>
        <input type="text" name="fname" id="fname" value="<?= htmlspecialchars($postData['fname'] ?? '') ?>" required>
        <br><br>

        <label for="mname">Middle Name</label>
        <input type="text" name="mname" id="mname" value="<?= htmlspecialchars($postData['mname'] ?? '') ?>">
        <br><br>

        <label for="lname">Last Name</label>
        <input type="text" name="lname" id="lname" value="<?= htmlspecialchars($postData['lname'] ?? '') ?>" required>
        <br><br>

        <label for="address">Address</label>
        <input name="address" id="address" value="<?= htmlspecialchars($postData['address'] ?? '') ?>" required>
        <br><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($postData['email'] ?? '') ?>" required>
        <br><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <span id="passwordMessage" class="error"></span><br><br>

        <button type="submit" id="submitBtn">Submit</button>
    </form>



    <script>
        document.getElementById("userForm").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirmation").value;
            var passwordMessage = document.getElementById("passwordMessage");

            if (password !== confirmPassword) {
                passwordMessage.textContent = "Passwords do not match!";
                event.preventDefault();
            } else {
                passwordMessage.textContent = "";
            }
        });
    </script>
</body>

</html>