<?php

namespace Hazesoft\Formhandeling\Services;

class Session
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function checkLogin(): bool
    {
        return isset($_SESSION['id']);
    }
}
