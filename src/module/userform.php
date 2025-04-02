<?php
namespace module;
require_once '../vendor/autoload.php';
use database\DbConnection;
use controller\Formreq;

require_once "../db/Dbconnection.php";
require_once "../controller/formreq.php";
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
