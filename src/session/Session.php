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
    public function getUserId(): ?int
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }

    public function setUserId(int $userId): void
    {
        $_SESSION['user_id'] = $userId;
    }
    public function getCartId(): ?int
    {
        return isset($_SESSION['cart_id']) ? $_SESSION['cart_id'] : null;
    }
    public function setCartId(int $cartId): void
    {
        $_SESSION['cart_id'] = $cartId;
    }

    public function logout(): void
    {
        unset($_SESSION['email']);
        session_destroy();
    }
}
