<?php

namespace App\model;

use App\validate\Seperator;
use App\validate\Validation;
use App\session\Session;
use App\Exception\CustomException;

class User
{
    private $conn;
    private Validation $validate;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->validate = new Validation();
    }

    public function register(array $details)
    {
        var_dump($details);
        $fetchEmail = "select * from users where email = ?";
        $emailStmt = $this->conn->prepare($fetchEmail);
        $emailStmt->bind_param("s", $details["email"]);
        $emailStmt->execute();
        $emailStore = $emailStmt->get_result();
        if ($emailStore->fetch_assoc() > 0) {
            die("user with this email already existed");
        }
        $query = "insert into users (firstName,middleName,lastName,email,password,address) values (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $details["firstName"], $details["middleName"], $details["lastName"], $details["email"], $details["password"], $details["address"],);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            header("Location: /product");
        } else {
            echo "failed";
        }
    }

    public function login(string $email, string $password)
    {
        $query = "select id,email,password from users where email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $store = $stmt->get_result();
        $user = $store->fetch_assoc();
        var_dump($user["id"]);
        $session = new Session();
        if (password_verify($password, $user["password"])) {
            $session->setSession("user_id", $user["id"]);
            header("Location: /product");
        } else {

            header("Location: /src/App/view/login.php");
        }
    }


    public function insertFromCsv(string $path)
    {
        if (($handle = fopen($path, "r")) !== false) {
            fgetcsv($handle, 0, ",", '"', "\\");    
            $batch = 500;
            $data = [];
            $insertedRow = 0;
            $query = "insert into users (firstName, middleName, lastName, email, address, password) values (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $this->conn->autocommit(false);
            while (($row = fgetcsv($handle, 500, ",", '"', "\\")) !== false) {
                if (count($row) < 3) {
                    continue;
                }
                $seperatedName = Seperator::seperate($row[0]);
                $firstName = $seperatedName["firstName"];
                $middleName = $seperatedName["middleName"] ?? "";
                $lastName = $seperatedName["lastName"];
                $address = $row[1];
                $email = $row[2];
                $values = [
                    "firstName" => $firstName,
                    "middleName" => $middleName,
                    "lastName" => $lastName,
                    "address" => $address,
                    "email" => $email,
                ];

                try {
                    $this->validate->validator($values);
                    $data[] = [$firstName, $middleName, $lastName, $address, $email];
                    $insertedRow++;
                    if (count($data) >= $batch) {
                        $this->batchInsert($stmt, $data);
                        $data = [];
                    }
                } catch (CustomException $exception) {
                    foreach ($exception->getTheError() as $errorTile => $errorMessage) {
                        echo $errorMessage;
                        die("");
                    }
                }
            }
            fclose($handle);
            $this->conn->commit();
            $stmt->close();
            return $insertedRow;
        }
    }

    public function batchInsert($stmt, array $datas)
    {
        foreach ($datas as $singleData) {
            $stmt->bind_param("ssssss", $singleData[0], $singleData[1], $singleData[2], $singleData[3], $singleData[4], $singleData[4]);
            $stmt->execute();
        }
    }
}
