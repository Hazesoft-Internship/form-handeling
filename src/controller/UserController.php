<?php

namespace App\controller;

require_once __DIR__."/../../vendor/autoload.php";
use App\validation\UserValidation;
use App\session\session;

class UserController
{    
    public function getLogin()
    {
        return require_once __DIR__."/../dashboard/login.html";
    }
    public function getSignUp() 
    {
        return require_once __DIR__."/../dashboard/signup.html";
    }
    public function getproductManagement()
    {
        $userName = strtoupper(session::getInstance()->get("userName"));
        return require_once __DIR__."/../dashboard/productManagement.php";
    }

    public function handlelogin()
    {
        return require_once "CheckLogin.php";
    }
    public function handleSignUp()
    {
        $UserValidate1 = new UserValidation();
        $UserValidate1->read();
    }
    public function handleLogOut()
    {
        session::getInstance()->destroySession();
    }
    
}
?>