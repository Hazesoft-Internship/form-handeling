<?php

namespace App\model;

session_start();
class User
{
    private $conn;
    private $fullname;
    private $email;
    private $password;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register(array $details)
    {
        $query = "insert into users (firstName,middleName,lastName,email,password,address) values (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $details["firstName"], $details["middleName"], $details["lastName"], $details["email"], $details["password"], $details["address"],);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "registered";
        } else {
            echo "failed";
        }
    }

    public function login($email, $password)
    {
        $query = "select id,email,password from users where email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $store = $stmt->get_result();
        $user = $store->fetch_assoc();
        if ($user["password"] == $password) {
            header("Location: /src/App/view/product.html");
            $_SESSION["user_id"] = $user["id"];
        } else {
            header("Location: /src/App/view/login.html");
        }
    }
}
