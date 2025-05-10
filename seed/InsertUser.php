<?php


use App\Data\Data;
use App\User\User;
use App\Database\Database;

require_once 'Data.php';
require_once 'User.php';
require_once './config/Database.php';


$data = Data::getData("../Data/users_data.csv");

$connection =  Database::connect();

foreach ($data as $row) {
    if ($data[0] == $row) {
        continue;
    }
    $divide = explode(" ", $row[0]);
    $last_name = array_pop($divide);
    $first_name = array_shift($divide);
    $middle_name = implode(" ", $divide);

    $user = new User($first_name, $middle_name, $last_name, $row[1], $row[2]);
    $user->register($connection);
}
