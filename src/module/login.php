<?php

namespace Lattefront\FormHandeling\Module;

session_start();

use Lattefront\FormHandeling\Db\DbConnection;
use Exception;
use mysqli;

class Login
{
    private mysqli $conn;

    public function __construct(DbConnection $db)

    {
        echo "here";
        $this->conn = $db->getConnection();


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['Email'];
            $password = $_POST['Password'];
        }
        // Prepare and execute
        try {
            print_r("here it is");
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
                    // var_dump( $_SESSION['email']); 

                    header("Location:/dashboard");
                    exit();
                } else {
                    echo "Incorrect credentials.";
                    throw new Exception("Incorrect credentials. Please try again.");
                }
            } else {
                header("Location: /signup");
                throw new Exception("Users not found .");
            }
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage(),);
        } finally {
            // Close the statement and connection  
            $stmt->close();
            $this->conn->close();
        }
    }
}
$userlogin = new Login(new DbConnection());
