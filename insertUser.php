<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("./vendor/autoload.php");
use App\controller\UserController;
use App\config\database;

$db = database::getInstance();
$conn= $db->getConnection();
$csv=new UserController($conn);
$csv->insertCsv(__DIR__."/src/App/data/user.csv");

?>