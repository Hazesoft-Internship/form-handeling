<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6124e2b (feat: add entire project directory)
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Form</title>
</head>
<body>

<!-- Creating a simple form -->
<form action="index.php" method="POST">
    <label for="first_name">First Name:</label><br>
    <input id="first_name" type="text" name="first_name" placeholder="*Required*"><br>

    <label for="middle_name">Middle Name:</label><br>
    <input id="middle_name" type="text" name="middle_name" placeholder="*Optional*"><br>

    <label for="last_name">Last Name:</label><br>
    <input id="last_name" type="text" name="last_name" placeholder="*Required*"><br>

    <label for="address">Address:</label><br>
    <input id="address" type="text" name="address" placeholder="*Required*"><br>

    <label for="email">Email:</label><br>
    <input id="email" type="email" name="email" placeholder="*Required*"><br>

    <input type="submit" value="Submit">
</form>

<<<<<<< HEAD
<?php
require 'classes/DB.php';
require 'classes/User.php';

use Classes\DB;
use Classes\User;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Form Validation 
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['email']) &&
        !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['address']) && !empty($_POST['email'])) {
        
        $db = new DB();
        $user = new User($db);
        $conn = $db->getConnection();
        
        // Preventing unusual input
        $userData = [
            'first_name' => htmlspecialchars($_POST['first_name']),
            'middle_name' => isset($_POST['middle_name']) ? htmlspecialchars($_POST['middle_name']) : '', 
            'last_name' => htmlspecialchars($_POST['last_name']),
            'address' => htmlspecialchars($_POST['address']),
            'email' => htmlspecialchars($_POST['email'])
        ];

        // Inserting data into database
        if ($user->insertUser($userData)) {
            echo "User information added into database successfully. <br>";
            
            // Exporting data to CSV
            $sql = "SELECT CONCAT(first_name, ' ', IFNULL(middle_name, ''), ' ', last_name) AS full_name, address, email FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $csvFile = 'info.csv';
            $file = fopen($csvFile, 'w');   

            fputcsv($file, ['Full Name', 'Address', 'Email']); // CSV Headers

            foreach ($users as $user) {
                fputcsv($file, $user);
            }

            fclose($file);

            echo "User information exported successfully to $csvFile.";
        } else {
            echo "Error adding user.";
        }
    // Error if the form is not submitted properly
    } else {
        echo "Form Submission Denied. <br> Kindly enter all *Required* fields (First Name, Last Name, Address, Email).";
    }
}
?>

</body>
</html>
=======
=======
>>>>>>> 6124e2b (feat: add entire project directory)
<?php
require 'classes/DB.php';
require 'classes/User.php';

use Classes\DB;
use Classes\User;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Form Validation 
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['email']) &&
        !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['address']) && !empty($_POST['email'])) {
        
        $db = new DB();
        $user = new User($db);
        $conn = $db->getConnection();
        
        // Preventing unusual input
        $userData = [
            'first_name' => htmlspecialchars($_POST['first_name']),
            'middle_name' => isset($_POST['middle_name']) ? htmlspecialchars($_POST['middle_name']) : '', 
            'last_name' => htmlspecialchars($_POST['last_name']),
            'address' => htmlspecialchars($_POST['address']),
            'email' => htmlspecialchars($_POST['email'])
        ];

        // Inserting data into database
        if ($user->insertUser($userData)) {
            echo "User information added into database successfully. <br>";
            
            // Exporting data to CSV
            $sql = "SELECT CONCAT(first_name, ' ', IFNULL(middle_name, ''), ' ', last_name) AS full_name, address, email FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $csvFile = 'info.csv';
            $file = fopen($csvFile, 'w');   

            fputcsv($file, ['Full Name', 'Address', 'Email']); // CSV Headers

            foreach ($users as $user) {
                fputcsv($file, $user);
            }

            fclose($file);

<<<<<<< HEAD
>>>>>>> 40cef57 (feat: added inital phase requirement)
=======
            echo "User information exported successfully to $csvFile.";
        } else {
            echo "Error adding user.";
        }
    // Error if the form is not submitted properly
    } else {
        echo "Form Submission Denied. <br> Kindly enter all *Required* fields (First Name, Last Name, Address, Email).";
    }
}
?>

</body>
</html>
>>>>>>> 6124e2b (feat: add entire project directory)
