<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Lattefront\FormHandeling\Router\Router;

$router = new Router();
$router->dispatch();
