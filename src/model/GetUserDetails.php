<?php

namespace ayushtamang\FormHandeling\model;

class GetUserDetails
{
    private $sqlData;
    
    public function __construct(private $con, $email) 
    {
        $this->con = $con;
        
        $query = $this->con->prepare("SELECT * FROM users WHERE email = :em");
        $query->bindParam(":em", $email);
        $query->execute();

        $this->sqlData = $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserId() 
    {
        return $this->sqlData["id"];
    }
    
    public function getEmail() 
    {
        return $this->sqlData["email"];
    }

    public function userExists() 
    {
        echo $this->sqlData["email"];
    }
}
?>