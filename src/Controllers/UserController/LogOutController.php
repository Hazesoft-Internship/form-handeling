<?php

namespace ECommerce\Controllers\UserController;

use ECommerce\Models\User;
use ECommerce\Services\Session;

class LogOutController
{
    private $user;
    private $session;
    public function __construct()
    {
        $this->user = new User();
        $this->session = Session::getInstance();
    }
    public function handleLogOut()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
            $logOutResult = $this->user->logOutUser($this->session);
            if ($logOutResult) {
                header('Location: /login');
                exit;
            }
            return "Failed to logout user";
        }
    }
}
