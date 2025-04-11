<?php

namespace Lattefront\FormHandeling\Middleware;

use Lattefront\FormHandeling\Session\Session;

class Authmiddleware
{
    public static function wrap(array $controller): callable
    {
        return function ($request) use ($controller) {
            $session = Session::getInstance();

            if ($session->isLoggedIn()) {
                [$class, $method] = $controller;
                $instance = new $class();
                return $instance->$method($request);
            }

            header("Location: /login");
            exit;
        };
    }
}
