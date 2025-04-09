<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Session\Session;

class AuthController
{ 
    private Session $session;
    private function checkLoggedIn(): void
    {
        $this->session = Session::getInstance();
        if ($this->session->isLoggedIn()) {
            header("Location: /dashboard");
            exit;
        }
    }
    public function signUp(): void
    {
        $this->checkLoggedIn();
        require __DIR__ . '/../View/Signup.php';
    }

    public function loginpage(): void
    {
        $this->checkLoggedIn();
        require __DIR__ . '/../View/loginpage.php';
    }
    public function login(): void
    {
        require __DIR__ . '/../Model/Login.php';
    }
    public function logout(): void
    {
        $this->session = Session::getInstance();
        $this->session->logout();
        header("Location: /login");
        exit;
    }
    
}
