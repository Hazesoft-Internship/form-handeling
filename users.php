<?php
require_once "db.php";

class User
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function create($fName, $mName, $lName, $address, $email): bool
    {
        $stmt = $this->connection->prepare("INSERT INTO users (first_name, middle_name, last_name, address, email) VALUES (?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new RuntimeException("Unable to prepare the statement");
        }

        $stmt->bind_param("sssss", $fName, $mName, $lName, $address, $email);

        if (!$stmt->execute()) {
            throw new RuntimeException("Unable to execute the query");
        }

        return true;
    }
}

class UserController
{
    private $user;
    private $errors = [];

    public function __construct()
    {
        $this->user = new User();
    }

    private function test_input($data): string
    {
        return htmlspecialchars(trim($data));
    }

    private function validateInput($data, $fieldName, $pattern = ""): string
    {
        if (empty($data)) {
            $this->errors[$fieldName] = "$fieldName is required";
            return "";
        }
        $data = $this->test_input($data);
        if ($pattern && !preg_match($pattern, $data)) {
            $this->errors[$fieldName] = "Invalid $fieldName format";
            return "";
        }
        return $data;
    }

    public function handleRequest(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fName = $this->validateInput($_POST["fname"] ?? "", "First name", "/^[a-zA-Z-' ]*$/");
            $mName = $this->validateInput($_POST["mname"] ?? "", "Middle name", "/^[a-zA-Z-' ]*$/");
            $lName = $this->validateInput($_POST["lname"] ?? "", "Last name", "/^[a-zA-Z-' ]*$/");
            $email = $this->validateInput($_POST["email"] ?? "", "Email", FILTER_VALIDATE_EMAIL ? "" : null);
            $address = $this->validateInput($_POST["address"] ?? "", "Address");

            if (empty($this->errors)) {
                try {
                    if ($this->user->create($fName, $mName, $lName, $address, $email)) {
                        echo "User added successfully!";
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                foreach ($this->errors as $error) {
                    echo $error . "<br>";
                }
            }
        }
    }
}

$controller = new UserController();
$controller->handleRequest();
