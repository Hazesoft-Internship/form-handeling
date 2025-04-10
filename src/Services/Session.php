<?php

namespace Hazesoft\Backend\Services;

class Session
{
    private static $instance = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance(): ?Session
    {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function setSession($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function hasSession($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function removeSession($key): void
    {
        $_SESSION[$key] = null;
    }

    public function destroySession(): void  // For logout page
    {
        session_unset();
        session_destroy();
    }
}