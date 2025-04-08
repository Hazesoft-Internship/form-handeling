<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Lattefront\FormHandeling\Router\Router;

$router = new Router();
$router->dispatch();
