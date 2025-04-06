<?php
namespace seeder;
use database\DbConnection;
use mysqli;

// Database connection class
require_once "./db/Dbconnection.php";

// CSV File Handling Class
class CSVHandler
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    // Write data to CSV file
    public function writeCSV(): void
    {
        $file = fopen($this->fileName, "w");

        // Write header
        fputcsv($file, ["Full Name", "Address", "Email"]);

        for ($i = 0; $i <= 10000; $i++) {
            // Write data rows
            fputcsv($file, ["Name{$i} middle{$i} last{$i}", "address{$i}", "mail@{$i}.com"]);
        }

        fclose($file);
        echo "CSV file created successfully.<br>";
    }

    // Read data from CSV file
    public function readCSV(): array
    {
        $file = fopen($this->fileName, "r");

        // Skip the header row
        fgetcsv($file);

        $data = [];
        while (($row = fgetcsv($file)) !== FALSE) {
            $data[] = $row;
        }

        fclose($file);
        return $data;
    }
}

// User Data Handler Class
class UserHandler
{
    private mysqli $conn;

    public function __construct(DbConnection $db)
    {
        $this->conn = $db->getConnection();
    }

    // Name Separator Function
    private function nameSeparator(string $fullName): array
    {
        $fullName = trim($fullName);
        $nameParts = explode(' ', $fullName);

        $firstName = $nameParts[0] ?? '';
        $middleName = isset($nameParts[2]) ? implode(' ', array_slice($nameParts, 1, -1)) : '';
        $lastName = end($nameParts) ?? '';

        return [$firstName, $middleName, $lastName];
    }

    // Insert users from CSV data into the database
    public function insertUsersFromCSV(array $data): void
    {
        foreach ($data as $row) {
            $address = $this->conn->real_escape_string($row[1]);
            $email = $this->conn->real_escape_string($row[2]);

            list($firstName, $middleName, $lastName) = $this->nameSeparator($row[0]);

            $sql = "INSERT INTO users (First_name, Middle_name, Last_name, Address, Email) 
                    VALUES ('$firstName', '$middleName', '$lastName', '$address', '$email')";

            if ($this->conn->query($sql)) {
                // echo "Record for {$firstName} inserted successfully.<br>";
            } else {
                echo "Error: " . $this->conn->error . "<br>";
            }
        }
    }
}

// Main Execution
$db = new DbConnection();
$csvHandler = new CSVHandler("users.csv");
$userHandler = new UserHandler($db);

// $csvHandler->writeCSV(); // Create CSV file
$data = $csvHandler->readCSV(); // Read data from CSV file
$userHandler->insertUsersFromCSV($data); // Insert users into the database
