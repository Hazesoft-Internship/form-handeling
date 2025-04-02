<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require "../config.php";

use ayushtamang\FormHandeling\session\Session;

$session = Session::getSession("userLoggedIn");

if (!isset($session)) {
    header("Location: login.php");
    exit();
}
?>