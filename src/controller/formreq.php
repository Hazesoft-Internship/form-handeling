<?php

namespace Lattefront\FormHandeling\Controller;

// require_once(__DIR__ . "/../../vendor/autoload.php");

use Lattefront\FormHandeling\Db\DbConnection;
use mysqli;
use Lattefront\FormHandeling\Controller\FormValidation;
use Exception;

// use Exception;

// require_once "../exceptionhandle.php";
// require_once "FormValidation.php";
class Formreq
{
    private mysqli $conn; // Store the mysqli connection

    public function __construct(DbConnection $dbConnection)
    {
        $this->conn = $dbConnection->getConnection(); // Get the mysqli connection

        try {
            $First_name = $_POST['First_name'];
            $Middle_name = $_POST['Middle_name'];
            $Last_name = $_POST['Last_name'];
            $Address = $_POST['Address'];
            $Email = $_POST['Email'];
            $Password = $_POST['Password'];
            $Password = password_hash($Password, PASSWORD_BCRYPT); // Hash the password

            $formdataArray = [
                $First_name,
                $Middle_name,
                $Last_name,
                $Address,
                $Email,
                $Password
            ];


            $formvalidate = new FormValidation();
            $message = $formvalidate->validate($formdataArray);



            if (empty($message)) //validation
            {
                $sql = "INSERT INTO users (First_name, Middle_name, Last_name, Address, Email,Password) VALUES (?, ?, ?, ?, ?,?)";

                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssssss", $First_name, $Middle_name, $Last_name, $Address, $Email, $Password);

                if ($stmt->execute()) {
                    echo "Record inserted successfully.";
                    echo "<br>";
                    echo "You will be redirected to the login page in 3 seconds.";
                    header("Refresh:3; url=/login");
                }
            } else {

                foreach ($message as $msg) {
                    echo $msg . "<br>";
                }
            }
            //need to check if the email already exists in the database
            //Uncaught Exception: Error: Duplicate entry 'xotavejuqo@mailinator.com' for key 'unique_email' 
        } catch (Exception $excep) {
            throw new Exception("Error: " . $excep->getMessage(),);
        } finally {

            $stmt->close();
        }
    }
}
