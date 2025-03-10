<?php

require_once "connection.php";

use Database\Connection;

$connection = new Connection('mysql', 'user', 'password', 'mydb');

$conn = $connection->connect();

// Open the CSV file
$file = fopen("sample_data.csv", "r");

if ($file === false) {
    die("Couldn't read csv file");
}

$headers = fgetcsv($file);

while (($rowData = fgetcsv($file)) !== false) {
    $fullName = $rowData[0];
    $address = $rowData[1];
    $email = $rowData[2];

    $namesArray = explode(" ", $fullName);

    $fName = $namesArray[0];
    $mName = $namesArray[1];
    $lName = $namesArray[2];

    $sql_insertuser = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`) VALUES ('$fName', '$mName', '$lName', '$address', '$email')";

    $result_user = mysqli_query($conn, $sql_insertuser);

    if ($result_user === false) {
        echo "Error inserting data: ";
    }

}

echo "Data inserted successfully";

fclose($file);

$connection->disconnect();

?>
