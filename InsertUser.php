<?php

class InsertUser {
    private $conn;
    private $file;
    private $headers;
    private $firstName;
    private $middleName;
    private $lastName;
    private $address;
    private $email;

    public function __construct() {
        $this->conn = mysqli_connect("127.0.0.1", "root", "", "mysql1");
        $this->file = fopen("insertuser.csv", "r");
        $this->headers = fgetcsv($this->file, 10000, ',');
    }

    public function uploadCSV() {
        if (!$this->file) {
            die("Couldn't read CSV file");
        }

        while ($row = fgetcsv($this->file, 10000, ',')) {
            $fullname = $row[0]; 
            $namesArray = explode(" ", $fullname);

            $this->firstName = $namesArray[0] ?? "";
            $this->middleName = count($namesArray) > 2 ? $namesArray[1] : "";
            $this->lastName = count($namesArray) > 1 ? end($namesArray) : "";
            $this->email = $row[1] ?? "";
            $this->address = $row[2] ?? "";

            $stmt = $this->conn->prepare("INSERT INTO users (firstName, middleName, lastName, email, address) VALUES (?, ?, ?, ?, ?)");

            if (!$stmt) {
                die("Statement creation failed: " . $this->conn->error);
            }

            $stmt->bind_param("sssss", $this->firstName, $this->middleName, $this->lastName, $this->email, $this->address);
            $stmt->execute();
            $stmt->close();
        }

        fclose($this->file);
    }
}

$insert = new InsertUser();
$insert->uploadCSV();

?>

