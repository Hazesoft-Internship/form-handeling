<?php
require_once "DbConnection.php";
require_once "Formreq.php";
class InsertUser
{
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $db = new DbConnection();

            $insertUser = new Formreq($db);
        } else {
            echo "Invalid request.";
        }
    }
}
$insertuserform = new InsertUser();
