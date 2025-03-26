<?php

use HazeSoft\Backend\formHandeling\models\User;

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    $user->logOutUser();
}
