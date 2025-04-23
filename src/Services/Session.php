<?php

namespace ECommerce\Services;

class Session
{
    private static $instance = null;
    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public static function getInstance(): object
    {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): string|null
    {
        return $_SESSION[$key];
    }

    public function destroy(): bool
    {
        session_unset();
        session_destroy();
        return true;
    }
}
