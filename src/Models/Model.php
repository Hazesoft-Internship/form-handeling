<?php

namespace App\Models;

use App\Config\DataBase;
use App\Sessions\Sessions;

class Model
{
    public $connection;
    public $session;
    public function __construct()
    {
        $this->connection = DataBase::connect();
        $this->session = Sessions::getInstance();
    }
}
