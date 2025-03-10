<?php
require_once 'dbConnection.php';

class InsertUser
{

    private $dbConnection;

    public function __construct(
        private string $filepath = "users.csv",
        private  $database = new DatabaseConnection()
    ) {
        $this->dbConnection = $this->database->connectDB();
    }

    private function bulkInsert(array $batchedData)
    {
        if (empty($batchedData)) {
            return;
        }

        $bulkInsertQuery = "INSERT INTO users (firstName, middleName, lastName, email, address) VALUES " . implode(', ', $batchedData);
        $insertBulkResult = mysqli_query($this->dbConnection, $bulkInsertQuery);

        if ($insertBulkResult) {
            return $insertBulkResult;
        } else {
            return false;
        }
    }

    public function insertUserToDB(): void
    {
        $csv = fopen($this->filepath, 'r');
        $batchedData = [];
        $batchSize = 500;

        fgetcsv($csv, 10000, ',');

        while (($csvData = fgetcsv($csv, 10000, ',')) !== FALSE) {
            $fullName = $csvData[0];
            $delimitedName = explode(" ", $fullName);
            $firstName = $delimitedName[0] ?? null;
            $middleName = isset($delimitedName[2]) ? $delimitedName[1] : null;
            $lastName = $delimitedName[count($delimitedName) - 1] ?? null;
            $address = $csvData[1];
            $email = $csvData[2];

            $batchedData[] = "('" . mysqli_real_escape_string($this->dbConnection, $firstName) . "', '" .
                mysqli_real_escape_string($this->dbConnection, $middleName) . "', '" .
                mysqli_real_escape_string($this->dbConnection, $lastName) . "', '" .
                mysqli_real_escape_string($this->dbConnection, $email) . "', '" .
                mysqli_real_escape_string($this->dbConnection, $address) . "')";

            if (count($batchedData) >= $batchSize) {
                $bulkInsertionResult =  $this->bulkInsert($batchedData);
                $batchedData = [];
            }
        }

        if ($bulkInsertionResult) {
            echo "CSV inserted successfully \n";
        } else {
            echo "Failed to insert user";
        }

        fclose($csv);
        mysqli_close($this->dbConnection);
    }
}

$result = new InsertUser;
$result->insertUserToDB();
