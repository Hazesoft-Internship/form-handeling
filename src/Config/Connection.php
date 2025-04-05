<?php

namespace Hazesoft\Backend\Config;

use Exception;

class Connection
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername = '127.0.0.1', $username = 'root', $password = '', $dbname = 'mydb')
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect()
    {
        try {
            $this->conn = new \mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if ($this->conn->connect_error) {
                die("Error connecting to database" . $this->conn->connect_error);
            }
            $conn = $this->conn;
            return $conn;
        } catch (Exception $exception) {
            die("Error connecting to the database: " . $exception->getMessage());
        }
    }
}
