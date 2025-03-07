<?php

require 'UserInserter.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=user_database', 'weave', 'weave@1');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Enables error handling with exceptions

    $userInserter = new UserInserter('submissions.csv', $pdo);
    $userInserter->insertUsers(10000);

    echo "Users inserted successfully.";
} catch (PDOException $e) { //Catch any exceptions in the database
    echo "Database connection failed: " . $e->getMessage();
}
