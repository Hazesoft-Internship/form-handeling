<?php
require_once 'dbConnection.php';

class ValidateInput
{
    protected function sanitizeUserInput($firstName, $middleName, $lastName, $email, $address): array | string
    {

        $patternName = "/^[a-zA-Z0-9]+$/";
        $patternEmail = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        if (!preg_match($patternName, $firstName) || !preg_match($patternName, $middleName) || !preg_match($patternName, $lastName) || !preg_match($patternEmail, $email)) {
            return "Invalid input";
        }
        $userArr = [$firstName, $middleName, $lastName, $email, $address];
        $sanitizedArr = [];
        $sanitizedArr = array_map(function ($userData) {
            $userData = trim($userData);
            return htmlspecialchars($userData);
        }, $userArr);
        return $sanitizedArr;
    }
}

class DatabaseHandler extends ValidateInput
{
    private $connection;
    private $result;

    public function __construct()
    {
        $this->connection = new DatabaseConnection();
        $this->result = $this->connection->connectDB();
    }

    public function insertUserData(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $firstName = $_POST["firstName"];
            $middleName = $_POST["middleName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $address = $_POST["address"];

            $sanitizedArr = $this->sanitizeUserInput($firstName, $middleName, $lastName, $email, $address);
            if ($sanitizedArr === "Invalid input") {
                echo "Invalid input";
                return;
            }

            $insertQuery = "INSERT INTO users (firstName, middleName, lastName, email, address) VALUES ('$sanitizedArr[0]','$sanitizedArr[1]','$sanitizedArr[2]','$sanitizedArr[3]','$sanitizedArr[4]')";
            $insertResult = mysqli_query($this->result, $insertQuery);

            if (!$insertResult) {
                echo "Failed to insert data";
            }

            echo "Data Insertion successful";
        }
    }
}
