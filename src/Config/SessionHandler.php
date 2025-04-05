<?php

namespace Hazesoft\Backend\Config;

class SessionHandler{

    public function __construct(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
    public function setSession($key, $value): void{
        $_SESSION[$key] = $value;
    }
    public function getSession($key): mixed{
        return $_SESSION[$key] ?? null;
    }
    public function hasSession($key): bool{
        return isset($_SESSION[$key]);
    }
    public function removeSession($key){
        $_SESSION[$key] =  null;
    }
    public function destroySession(){  // For logout page
        session_unset();
        session_destroy();
    }
}