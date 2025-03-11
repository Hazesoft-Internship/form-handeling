<?php

// Database Connection 

require_once "validation.php";

class Database
{
    private $connection;

    public function connect()
    {
       return $this->connection = mysqli_connect('127.0.0.1', 'root', "", 'mysql1');
    }
}
