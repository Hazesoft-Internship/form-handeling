<?php

require_once 'db.php';

class InsertUser
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function parseAndInsert(string $csvFile): void
    {
        if (($handle = fopen($csvFile, 'r')) !== false) {
            fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $fullName = $data[0];
                $nameParts = $this->splitName($fullName);
                $this->insertData($nameParts, $data);
            }
            fclose($handle);
        } else {
            echo 'Error opening the file.';
        }
    }

    private function splitName(string $fullName): array
    {
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        $middleName = (count($nameParts) > 2) ? implode(' ', array_slice($nameParts, 1, count($nameParts) - 2)) : '';
        $lastName = (count($nameParts) > 1) ? end($nameParts) : '';
        return [$firstName, $middleName, $lastName];
    }

    private function insertData(array $nameParts, array $data)
    {
        $firstName = $nameParts[0];
        $middleName = $nameParts[1];
        $lastName = $nameParts[2];
        $address = $data[1];
        $email = $data[2];

        $stmt = $this->connection->prepare(
            'INSERT INTO users (first_name, middle_name, last_name, address, email) VALUES (?, ?, ?, ?, ?)'
        );

        if ($stmt) {
            $stmt->bind_param('sssss', $firstName, $middleName, $lastName, $address, $email);

            if ($stmt->execute()) {
                return true;
            } else {
                return 'Error inserting record: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            return 'Error preparing statement: ' . $this->connection->error;
        }
    }
}
$insertUser = new InsertUser();
$insertUser->parseAndInsert('users.csv');
