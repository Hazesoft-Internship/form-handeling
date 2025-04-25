<?php

namespace Lattefront\FormHandeling\Model;


use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Session\Session;


class Model
{
    protected $conn;
    protected $session;
    public function __construct()
    {
        $db = new DbConnection();
        $this->conn = $db->getConnection();
        $this->session = Session::getInstance();

    }
}
