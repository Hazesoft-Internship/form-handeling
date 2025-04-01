<?php
echo"hi";
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../vendor/autoload.php");

use App\controller\UserController;
use App\config\Database;

$db = Database::getInstance();
$conn= $db->getConnection();
$user = new UserController($conn);
$user->register();