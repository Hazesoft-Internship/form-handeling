<?php

require_once 'database.php';

class UserImporter
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function importFromCSV(string $csvFile): void
    {
        if (!file_exists($csvFile) || !is_readable($csvFile)) {
            die("Error: File does not exist or is not readable.");
        }

        if (($handle = fopen($csvFile, 'r')) !== false) {
            fgetcsv($handle); 

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($data) < 3) {
                    echo "Skipping invalid row: " . implode(", ", $data) . "\n";
                    continue;
                }
                
                $nameParts = $this->splitFullName($data[0]);
                $this->insertUser($nameParts, $data);
            }
            fclose($handle);
        } else {
            echo "Error opening the file.";
        }
    }

    private function splitFullName(string $fullName): array
    {
        $nameParts = explode(' ', trim($fullName));
        $firstName = $nameParts[0] ?? '';
        $middleName = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';
        $lastName = count($nameParts) > 1 ? end($nameParts) : '';
        
        return [$firstName, $middleName, $lastName];
    }

    private function insertUser(array $nameParts, array $data): void
    {
        [$firstName, $middleName, $lastName] = $nameParts;
        $address = $data[1] ?? '';
        $email = $data[2] ?? '';

        $stmt = $this->connection->prepare(
            'INSERT INTO users (first_name, middle_name, last_name, address, email) VALUES (?, ?, ?, ?, ?)'
        );

        if (!$stmt) {
            echo "Error preparing statement: " . $this->connection->error . "\n";
            return;
        }

        $stmt->bind_param('sssss', $firstName, $middleName, $lastName, $address, $email);

        if (!$stmt->execute()) {
            echo "Error inserting record: " . $stmt->error . "\n";
        }
        
        $stmt->close();
    }
}

$importer = new UserImporter();
$importer->importFromCSV('user.csv');
