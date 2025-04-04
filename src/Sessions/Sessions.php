<?php

namespace App\Sessions;


class Sessions
{
    public function __construct()
    {
        session_start();
    }

    public function setSession(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getSession(string $key): ?array
    {
        return $_SESSION[$key] ?? null;
    }

    public function destroySession(): void
    {
        session_unset();
        session_destroy();
    }
}
