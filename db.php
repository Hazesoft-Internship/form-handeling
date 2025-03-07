<?php
class Database
{
    private PDO $construction;

    public function __construct( //Constructor to establish a connection to the database
        private string $dsn = 'mysql:host=localhost;dbname=user_database',
        private string $username = 'weave',
        private string $password = 'weave@1',
        private array $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Enables error handling with exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Fetches results as associative arrays
        ]
    ) {
        try {
            $this->construction = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage()); //Stop the script and display the error message
        }
    }

    public function getConnection(): PDO //Return the PDO object to be used in FormHandler.php
    {
        return $this->construction;
    }
}
