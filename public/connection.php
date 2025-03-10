<?php

namespace Database;

class Connection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname){
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect() {
        $this->conn = new \mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if($this->conn->connect_error){
            echo "Error connecting to database". $this->conn->connect_error;
        }
        $conn = $this->conn;
        return $conn;
    }

    public function disconnect(){
        if($this->conn){
            $this->conn->close();
            $this->conn = null;
        }
    }

    public function input_data($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

} 

?>