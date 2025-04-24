<?php

namespace App\Model;
require_once __DIR__. "/../../vendor/autoload.php";

use App\Model\Database;

class GetConnection
{
    public $conn;
    public function __construct()
    {
        try
        {
            $this->conn = Database::getInstance()->getConnection();
        }
        catch(PDOException $e)
        {
            die("Connection Error : ".$e->getMessage());
        }
    }
}
