<?php

namespace App\session;

class Session
{
    private static $instance = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }


    public function setSession(string $key,$value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function hasSession($key)
    {
        return isset($_SESSION[$key]);
    }
}
