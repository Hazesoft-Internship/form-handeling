<?php
require_once(__DIR__ . "/../config/database.php");

class FormHandler
{

    private FormValidator $validate;
    public function __construct(private $mysqli = null)
    {
        $this->mysqli = connectDatabase::getConnection();
        $this->validate = new FormValidator();
    }

    public function insertForm(array $formData)
    {
        $seperatedFullName = NameSeperator::seperate($formData["fullname"]);
        $firstName = $seperatedFullName['firstName'];
        $middleName = isset($seperatedFullName['middleName']) ? $seperatedFullName['middleName'] : null;
        $lastName = $seperatedFullName['lastName'];
        $address = trim($formData['address']);
        $email = trim($formData['email']);

        $sendToValidate = [
            "firstName" => $firstName,
            "middleName" => $middleName,
            "lastName" => $lastName,
            "address" => $address,
            "email" => $email,
        ];

        if ($this->validate->validator($sendToValidate)) {
            $stmt = $this->mysqli->prepare("INSERT INTO users (firstName, middleName, lastName, address, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstName, $middleName, $lastName, $address, $email);

            if ($stmt->execute()) {
                echo "Data inserted successfully!";
            } else {
                echo "Error while inserting data";
            }

            $stmt->close();
        } else {
            $errArray = $this->validate->getError();
            foreach ($errArray as $key => $value) {
                echo " " . $key . " : " . $value . "<br>";
            }
        }

        $this->mysqli->close();
    }


    public function insert(string $path)
    {
        if (($handle = fopen($path, "r")) !== false) {

            fgetcsv($handle);
            $stmt = $this->mysqli->prepare("INSERT INTO users (firstName, middleName, lastName, address, email) VALUES (?, ?, ?, ?, ?)");
            $insertedRow = 0;
            $batchSize = 500;
            $data = [];

            $this->mysqli->autocommit(false);

            while (($row = fgetcsv($handle, 500, ",", '"', "\\")) !== false) {
                if (count($row) < 3) {
                    continue;
                }

                $actualVariables = NameSeperator::seperate($row[0]);
                $firstName = $actualVariables["firstName"];
                $middleName = $actualVariables["middleName"] ?? null;
                $lastName = $actualVariables["lastName"];
                $address = trim($row[1]);
                $email = trim($row[2]);

                $sendToValidate = [
                    "firstName" => $firstName,
                    "middleName" => $middleName,
                    "lastName" => $lastName,
                    "address" => $address,
                    "email" => $email,
                ];

                if ($this->validate->validator($sendToValidate)) {
                    $data[] = [$firstName, $middleName, $lastName, $address, $email];
                    $insertedRow++;

                    if (count($data) >= $batchSize) {
                        $this->insertBatch($stmt, $data);
                        $data = [];
                    }
                } else {
                    echo "Validation error for: $firstName $lastName\n";
                }
            }

            if (count($data) > 0) {
                $this->insertBatch($stmt, $data);
            }

            $this->mysqli->commit();
            fclose($handle);
            $stmt->close();
            $this->mysqli->close();
        } else {
            echo "Error opening file.";
        }
    }

    private function insertBatch($stmt, $data)
    {
        foreach ($data as $record) {
            $stmt->bind_param("sssss", $record[0], $record[1], $record[2], $record[3], $record[4]);
            $stmt->execute();
        }
    }
}
