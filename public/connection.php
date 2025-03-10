<?php

$servername = "mysql";  
$username = "user";         
$password = "password";            
$dbname = "mydb";           

// Create connection - ONLY ONCE
$conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

// Common utility functions that can be shared across files
function input_data($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>