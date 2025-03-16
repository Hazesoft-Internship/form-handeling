<?php
include_once "query.php";

class InsertUser
{
    public function insertUsers($filePath)
    {
        if (!file_exists($filePath)) {
            die("CSV file not found");
        }

        $file = fopen($filePath, "r");
        fgetcsv($file);

        $query = new Query();

        while (($line = fgetcsv($file)) !== false) {
            $nameParts = $this->splitName(trim(mysqli_real_escape_string($query->conn, $line[0])));
            $first_name = $nameParts["first_name"];
            $middle_name = $nameParts["middle_name"];
            $last_name = $nameParts["last_name"];
            $address = trim(mysqli_real_escape_string($query->conn, $line[1]));
            $email = trim(mysqli_real_escape_string($query->conn, $line[2]));
            $sql = "INSERT INTO user (first_name, middle_name, last_name, address, email) VALUES ('$first_name', '$middle_name', '$last_name', '$address', '$email');";

            $query->query($sql);
        }
        fclose($file);
        echo "Users added successfully";
    }

    private function splitName($name)
    {
        $names = explode(" ", $name);
        return [
            "first_name" => $names[0],
            "middle_name" => isset($names[2]) ? $names[1] : "",
            "last_name" => end($names)
        ];
    }
}

$insertUser = new InsertUser();
$insertUser->insertUsers("users.csv");
