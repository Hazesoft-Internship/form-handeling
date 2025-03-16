<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    if (!isset($_POST['first_name']) || $_POST['first_name'] == "") {
        $errors["first_name"] = "First name is required";
    }
    if (!isset($_POST['last_name']) || $_POST['last_name'] == "") {
        $errors["last_name"] = "Last name is required";
    }
    if (!isset($_POST['address']) || $_POST['address'] == "") {
        $errors["address"] = "Address is required";
    }
    if (!isset($_POST['email']) || $_POST['email'] == "") {
        $errors["email"] = "Email is required";
    }
    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is invalid";
    }
    if (count($errors) == 0) {
        include_once "query.php";

        $first_name = $_POST["first_name"];
        $middle_name = $_POST["middle_name"];
        $last_name = $_POST["last_name"];
        $address = $_POST["address"];
        $email = $_POST["email"];

        $query = new Query();

        $sql = "INSERT INTO user (first_name, middle_name, last_name, address, email) VALUES ('$first_name','$middle_name','$last_name', '$address', '$email')";

        $result = $query->query($sql);

        if ($result) {
            echo "User added successfully";
        } else {
            echo "Failed to add user";
        }
    }
}
?>
<form action="" method="post">
    <h1>Add New User</h1>
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name">
    <?php
    if (isset($errors["first_name"])) {
    ?>
        <p><?= $errors["first_name"] ?></p>
    <?php
    }
    ?>
    <br>
    <label for="middle_name">Middle Name</label>
    <input type="text" id="middle_name" name="middle_name">
    <?php
    if (isset($errors["middle_name"])) {
    ?>
        <p><?= $errors["middle_name"] ?></p>
    <?php
    }
    ?>
    <br>
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name">
    <?php
    if (isset($errors["last_name"])) {
    ?>
        <p><?= $errors["last_name"] ?></p>
    <?php
    }
    ?>
    <br>
    <label for="address">Address</label>
    <input type="text" id="address" name="address">
    <?php
    if (isset($errors["address"])) {
    ?>
        <p><?= $errors["address"] ?></p>
    <?php
    }
    ?>
    <br>
    <label for="email">Email</label>
    <input type="email" id="email" name="email">
    <?php
    if (isset($errors["email"])) {
    ?>
        <p><?= $errors["email"] ?></p>
    <?php
    }
    ?>
    <br>
    <button type="submit">Add</button>
</form>