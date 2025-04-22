<?php

namespace Hazesoft\Formhandeling\Models;


class InsertUser extends BaseModel
{
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

    private function insertData(array $nameParts, array $data): bool|string
    {
        $firstName = $nameParts[0];
        $middleName = $nameParts[1];
        $lastName = $nameParts[2];
        $address = $data[1];
        $email = $data[2];

        try {
            $stmt = $this->connection->prepare(
                'INSERT INTO users (first_name, middle_name, last_name, address, email) 
                 VALUES (:first_name, :middle_name, :last_name, :address, :email)'
            );

            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':middle_name', $middleName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                return true;
            } else {
                return 'Error inserting record.';
            }
        } catch (\PDOException $e) {
            return 'Error inserting record: ' . $e->getMessage();
        }
    }
}
$insertUser = new InsertUser();
$insertUser->parseAndInsert(__DIR__ . "/../storage/users.csv");
