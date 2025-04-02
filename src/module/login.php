<?php

namespace module;
require_once '../vendor/autoload.php';
use database\DbConnection;
use mysqli;

require_once "../db/Dbconnection.php";
session_start();


class Login
{
    private mysqli $conn;

    public function __construct(DbConnection $db)
    {
        $this->conn = $db->getConnection();


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['Email'];
            $password = $_POST['Password'];
        }
        // Prepare and execute

        $stmt = $this->conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Start the session and redirect to the dashboard

                $_SESSION['email'] = $email;
                header("Location:../view/dashboard.php");
                exit();
            } else {
                echo "Incorrect credentials. Please try again.";

                exit();
            }
        } else {
            echo "Incorrect credentials. Please try again.";
        }

        $stmt->close();
        $this->conn->close();
    }
}
$userlogin = new Login(new DbConnection());
