<?php

namespace ECommerce\Middlewares;

use ECommerce\Middlewares\Middleware;
use ECommerce\Services\Session;

class SessionMiddleware extends Middleware
{
    public function handle(): bool
    {
        $session = Session::getInstance();
        if (!$session->get('LoggedIn')) {
            header('Location: /login');
            return false;
        };
        return true;
    }
}
