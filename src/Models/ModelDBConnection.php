<?php

namespace ECommerce\Models;

use ECommerce\Services\DatabaseConnection;

class ModelDBConnection
{
    protected $dbConnection;
    public function __construct()
    {
        $this->dbConnection = DatabaseConnection::getInstance();
    }
}
