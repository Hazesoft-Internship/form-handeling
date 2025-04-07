<?php

namespace Lattefront\FormHandeling\Module;


use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Controller\Formreq;

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
