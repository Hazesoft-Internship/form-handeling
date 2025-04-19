<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Session\Session;
use PDO;
use Exception;

class UserModel
{
    private $conn;
    private Session $session; // Store the session instance

    public function __construct(DbConnection $dbConnection)
    {
        $this->conn = $dbConnection->getConnection(); // Get the database connection
        $this->session = Session::getInstance(); // Initialize the session instance
    }

    public function registerUser($First_name, $Middle_name, $Last_name, $Address, $Email, $Password): array
    {

        try {
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
                $userId = $this->conn->lastInsertId();

                //  cart for this user
                $stmt = $this->conn->prepare("INSERT INTO carts (user_id, created_at, updated_at) VALUES (?, NOW(), NOW())");
                $stmt->bindValue(1, $userId, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return ['success' => true, 'message' => 'User registered successfully. Redirecting to login page.'];
                }
                // $cartId = $this->conn->lastInsertId();
                // $this->session->setCartId($cartId); // Set the cart ID in the session
            }
            return ['success' => false, 'message' => 'Failed to register user.'];
        } catch (Exception $ex) {
            return ['success' => false, 'message' => 'Error: ' . $ex->getMessage()];
        }
    }
    public function loginUser($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['password'])) {
                $hashedPassword = $result['password'];

                // Verify the password
                if (password_verify($password, $hashedPassword)) {
                    // Start the session and redirect to the dashboard

                    $this->session->login($email);
                    $this->session->setUserId($result['user_id']);                    

                    
                    
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
            $stmt = null;
            $this->conn = null;
        }
    }
}
