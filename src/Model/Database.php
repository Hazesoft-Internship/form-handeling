<?php

namespace App\Model;

require_once __DIR__.'/../../vendor/autoload.php';
use PDO;

class Database
{
    public $connection;
    private static $instance=null;
     
    private function __construct(
        private $serverName = 'localhost',
        private $userName = 'root',
        private $password = '',
        private $dbName = 'mysql1',
        private $port = '3306'
     )

      {
        $this->connection = new PDO("mysql:host={$this->serverName};
                                    dbname={$this->dbName};
                                    port={$this->port}",
                                    "{$this->userName}",
                                    "{$this->password}");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

      public static function getInstance(): object
      {
        if(self::$instance==null)
        {
            self::$instance= new Database();
        }
        return self::$instance;
      }

      public function getConnection(): PDO
      {
          return $this->connection;
      }
}

