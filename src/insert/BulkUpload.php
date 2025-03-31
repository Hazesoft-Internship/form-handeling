<?php

class BulkUpload 
{
    public function __construct(private $con) 
    {
        $this->con = $con;
    }

    public function insertUsersFromCSV($csvFilePath): void  
    {
        if (($containsFile = fopen($csvFilePath, "r")) !== FALSE) {
            fgetcsv($containsFile); // Skip the header row
            while (
                ($data = fgetcsv($containsFile, 1000, ",")) !== FALSE
                ) 
            {
                $fullName = $data[0];
                $address = $data[1];
                $email = $data[2];
                $password = $data[3];
                $password = hash("sha512", $password);

                list($firstName, $middleName, $lastName) = $this->splitFullName($fullName);

                $query = $this->con->prepare("INSERT INTO users (firstName, middleName, lastName, address, email, password) 
                                            VALUES (?, ?, ?, ?, ?, ?)");
                $query->bind_param("ssssss", $firstName, $middleName, $lastName, $address, $email, $password);
                $query->execute();
            }
            fclose($containsFile);
        }
    }

    private function splitFullName($fullName): array 
    {
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        $middleName = '';
        $lastName = '';

        if (count($nameParts) == 2) {
            $lastName = $nameParts[1];
        } elseif (count($nameParts) > 2) {
            $middleName = $nameParts[1];
            $lastName = $nameParts[2];
        }

        return [$firstName, $middleName, $lastName];
    }
}
?>
