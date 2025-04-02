<?php

namespace ayushtamang\FormHandeling\session;

class Session
{
    private $key, $value;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getSession($key)
    {
        return $_SESSION[$key] ?? null;
    }
}
?>