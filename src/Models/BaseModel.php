<?php

namespace Hazesoft\Formhandeling\Models;

use Hazesoft\Formhandeling\Services\Database;
use Hazesoft\Formhandeling\Services\Session;

$session = Session::getInstance();

$session->start();

class BaseModel
{
    protected $connection;
    protected $userid;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
        $this->userid = $_SESSION['id'] ?? null;
    }
}
