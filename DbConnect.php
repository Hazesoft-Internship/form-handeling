<?php


class DBConnect
{

    public static $Instance = null;

    private function __construct(
        private string $servername,
        private string $username,
        private string $password,
        private string $dbname,
    ) {}

    public static function getInstance(string $servername, string $username, string $password, string $dbname): object
    {
        if (self::$Instance == null) {
            self::$Instance = new DBConnect($servername, $username, $password, $dbname);
        }
        return self::$Instance;
    }

    public function createConnection(): object|null
    {


        try {
            $connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if ($connection->connect_error) {
                throw new Exception("Could not connect: " . $connection->connect_error);
            }

            echo "Connected successfully";

            return $connection;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return null;
        }
    }
}
