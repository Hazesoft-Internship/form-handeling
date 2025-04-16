<?php

namespace ECommerce\Services;

class Session
{
    private static $instance = null;
    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
        return true;
    }
}
