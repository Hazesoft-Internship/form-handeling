<?php
session_start();

require_once '../config/db.php';
require_once '../classes/User.php';
include '../views/login.html';

use Product\Config\Database;
use Product\Classes\User;

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->loginUser($email, $password)) {
        $_SESSION['user_id'] = $user->getUserByEmail($email)['id'];
        $_SESSION['logged_in'] = true;
        header("Location: ../public/index.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
