<?php
$servername = "localhost"; 
$username = "root"; 
$password = "123"; 
$dbname = "data"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['Middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    $sql = "INSERT INTO your_table_name (firstname, middlename, lastname, address, email) 
            VALUES ('$firstname', '$middlename', '$lastname', '$address', '$email')";

 
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$conn->close();
?>
