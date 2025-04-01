<?php

namespace App\session;

class Session
{
    private $key;
    private $value;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function setSession($key, $value)
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
