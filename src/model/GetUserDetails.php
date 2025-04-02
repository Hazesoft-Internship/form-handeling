<?php

namespace ayushtamang\FormHandeling\model;

class GetUserDetails
{
    private $sqlData;
    
    public function __construct(private $con, $em) 
    {
        $this->con = $con;
        
        $query = $this->con->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $em);
        $query->execute();

        $result = $query->get_result();
        $this->sqlData = $result->fetch_assoc();
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