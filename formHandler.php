<?php

require_once 'databaseHandler.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST)) {
    $insertUserHandler = new DatabaseHandler();
    $insertUser = $insertUserHandler->insertUserData();
} else {
    header("Location: index.php");
    exit();
}
