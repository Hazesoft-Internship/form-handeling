<?php

namespace App\Sessions;


class Sessions
{


    public function __construct()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setSession(string $key, array $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getSession(string $key): ?array
    {
        return $this->hasSession($key) ? $_SESSION[$key] : null;
    }

    public function hasSession(string $key): bool
    {

        return array_key_exists($key, $_SESSION);
    }
    public function removeSession(string $key): void
    {
        if ($this->hasSession($key)) {
            unset($_SESSION[$key]);
        }
    }
    public function clearSession(): void
    {
        session_unset();
    }
}
