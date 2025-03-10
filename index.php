<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="post">
        <label>fullname</label>
        <input name="fullname" type="text" />
        <label>address</label>
        <input name="address" type="text" />
        <label>email</label>
        <input name="email" type="email" />
        <button type="submit">submit</button>
    </form>
</body>

</html>

<?php
require_once("./src/FormHandler.php");
require_once("./src/FormValidator.php");
require_once("./src/NameSeperator.php");
$form = new FormHandler();
$formValidator = new FormValidator();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        "fullname" => $_POST["fullname"] ?? "",
        "address" => $_POST["address"] ?? "",
        "email" => $_POST["email"] ?? "",
    ];
    $form->insertForm($formData);
    foreach ($formValidator->getError() as $x => $x_value) {
        echo $x;
    }
}
?>