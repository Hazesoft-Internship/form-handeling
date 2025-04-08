<?php

namespace Lattefront\FormHandeling\Module;


use Lattefront\FormHandeling\session\Session;
use Lattefront\FormHandeling\Db\DbConnection;
use Exception;
use PDO;

class Login
{
    private $conn;
    private Session $session; 

    
    public function __construct(DbConnection $db)

    {
        $this->session = Session::getInstance(); // Initialize the session instance
        $this->conn = $db->getConnection();


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['Email'];
            $password = $_POST['Password'];
        }
        // Prepare and execute
        try {
            $stmt = $this->conn->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['password'])) {
                $hashedPassword = $result['password'];

                // Verify the password
                if (password_verify($password, $hashedPassword)) {
                    // Start the session and redirect to the dashboard
                   
                    $this->session->login($email);                   

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
            $stmt = null;
            // Close the connection
            $this->conn = null;
        }
    }
}
$userlogin = new Login(new DbConnection());
