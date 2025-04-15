<?php

namespace App\connectDB;

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
        //this throws an error if anything were to wrong
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

      public static function getInstance()
      {
        if(self::$instance==null)
        {
            self::$instance= new Database();
        }
        return self::$instance;
      }

      public function getConnection()
      {
          return $this->connection;
      }
}

