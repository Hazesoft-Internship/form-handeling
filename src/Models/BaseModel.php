<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Services\Connection;

class BaseModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }
}