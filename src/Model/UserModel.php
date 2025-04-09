<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Service\FormValidation;
use PDO;
use Exception;

class UserModel
{
    private $conn;

    public function __construct(DbConnection $dbConnection)
    {
        $this->conn = $dbConnection->getConnection(); // Get the database connection
    }

    public function registerUser($formData)
    {
        try {
            // Extract form data
            $First_name = $formData['First_name'];
            $Middle_name = $formData['Middle_name'];
            $Last_name = $formData['Last_name'];
            $Address = $formData['Address'];
            $Email = $formData['Email'];
            $Password = password_hash($formData['Password'], PASSWORD_BCRYPT); // Hash the password

            // Validate form data
            $formvalidate = new FormValidation();
            $messages = $formvalidate->validate([$First_name, $Middle_name, $Last_name, $Address, $Email, $Password]);

            if (empty($messages)) {
                // Insert user data into the database
                $sql = "INSERT INTO users (First_name, Middle_name, Last_name, Address, Email, Password) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(1, $First_name, PDO::PARAM_STR);
                $stmt->bindValue(2, $Middle_name, PDO::PARAM_STR);
                $stmt->bindValue(3, $Last_name, PDO::PARAM_STR);
                $stmt->bindValue(4, $Address, PDO::PARAM_STR);
                $stmt->bindValue(5, $Email, PDO::PARAM_STR);
                $stmt->bindValue(6, $Password, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    return ['success' => true, 'message' => 'User registered successfully. Redirecting to login page.'];
                }
            } else {
                return ['success' => false, 'message' => implode('<br>', $messages)];
            }
        } catch (Exception $ex) {
            return ['success' => false, 'message' => 'Error: ' . $ex->getMessage()];
        }
    }
}

