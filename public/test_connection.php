<?php
// filepath: /home/samir/Desktop/Next/formhandling/public/test_connection.php

require_once "connection.php";

// Test the connection
if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed: " . mysqli_connect_error();
}

?>