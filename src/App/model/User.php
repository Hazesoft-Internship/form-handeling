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
        $fetchEmail = "select * from users where email = :email";
        $emailStmt = $this->conn->prepare($fetchEmail);
        $emailStmt->bindValue(':email', $details["email"]);
        $emailStmt->execute();
        if ($emailStmt->fetch(\PDO::FETCH_ASSOC)) {
            die("user with this email already existed");
        }
        $query = "insert into users (firstName,middleName,lastName,email,password,address) values (:firstName,:middleName,:lastName,:email,:password,:address)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":firstName", $details["firstName"]);
        $stmt->bindValue(":middleName", $details["middleName"]);
        $stmt->bindValue(":lastName", $details["lastName"]);
        $stmt->bindValue(":email", $details["email"]);
        $stmt->bindValue(":password", $details["password"]);
        $stmt->bindValue(":address", $details["address"]);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            header("Location: /product");
        } else {
            echo "failed";
        }
    }

    public function login(string $email, string $password)
    {
        $query = "select id,email,password from users where email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        var_dump($user["id"]);
        $session = Session::getInstance();
        if (password_verify($password, $user["password"])) {
            $session->setSession("user_id", $user["id"]);
            header("Location: /product");
        } else {

            header("Location: /login");
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
            $stmt->bindValue("ssssss", $singleData[0], $singleData[1], $singleData[2], $singleData[3], $singleData[4], $singleData[4]);
            $stmt->execute();
        }
    }
}
