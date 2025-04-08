<?php

namespace Lattefront\FormHandeling\session;

class Session
{
    private static ?Session $instance = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['email']);
    }

    public function getLoggedInUser(): ?string
    {
        return $this->isLoggedIn() ? $_SESSION['email'] : null;
    }

    public function login(string $email): void
    {
        $_SESSION['email'] = $email;
    }

    public function logout(): void
    {
        unset($_SESSION['email']);
        session_destroy();
    }

   
}