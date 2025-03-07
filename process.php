<?php

// Used require instead of include to stop the script if the file is not found
require 'db.php';
require 'FormHandler.php';

$database = new Database();
$construction = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST
    // trim() removes whitespace from the beginning and end of the string and htmlspecialchars() converts special characters to HTML entities
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $middle_name = htmlspecialchars(trim($_POST['middle_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Create a new FormHandler object and process the form data
    $formHandler = new FormHandler($first_name, $middle_name, $last_name, $address, $email, $construction);
    $formHandler->process();

    // Combine names into full name and trim any extra whitespace
    $full_name = trim("$first_name $middle_name $last_name");

    // Open the CSV file for appending
    $file = fopen('submissions.csv', 'a');

    // Check if the file is empty and write headers if it is
    if (filesize('submissions.csv') == 0) {
        fputcsv($file, ['Full Name', 'Address', 'Email']);
    }

    // Write the data to the CSV file
    fputcsv($file, [$full_name, $address, $email]);

    // Close the file
    fclose($file);
} else {
    echo "Invalid request method.";
}
