<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("./src/App/config/database.php");
require_once("./src/App/model/User.php");
require_once("./src/App/controller/UserController.php");

use App\controller\UserController;


$conn = database::connectDB();
$user = new UserController($conn);
$user->login();
