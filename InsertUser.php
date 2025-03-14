<?php


require_once 'Data.php';
require_once 'User.php';
require_once 'DbConnect.php';


$data = Data::getData("./users_data.csv");

$connection = DBConnect::getInstance("localhost", "php", "password", "testdb")->createConnection();


foreach ($data as $row) {
    if ($data[0] == $row) {
        continue;
    }
    $divide = explode(" ", $row[0]);
    $last_name = array_pop($divide);
    $first_name = array_shift($divide);
    $middle_name = implode(" ", $divide);

    $user = new User($first_name, $middle_name, $last_name, $row[1], $row[2]);
    $user->insertUser($connection);
}
