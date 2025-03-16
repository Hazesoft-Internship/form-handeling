<?php
include_once "connectDB.php";

class Query extends connectDB
{
    public function query($sql)
    {
        $result = $this->conn->query($sql);
        return $result;
    }
}
