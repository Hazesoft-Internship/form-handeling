<?php

namespace Lattefront\FormHandeling\Router;

class Router
{
    protected array $routes = [];

    public function __construct()
    {
        $this->routes = require __DIR__ . '/../../Config/RouterConfig.php';
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = explode('?', $_SERVER['REQUEST_URI'] ?? '/')[0];

        $callback = $this->routes[$method][$path] ?? null;

        if (!$callback) {
            http_response_code(404);
            echo "404 - Route Not Found";
            return;
        }

        if (is_callable($callback)) {
            call_user_func($callback, $_REQUEST);
            return;
        }

        if (is_array($callback)) {
            [$class, $method] = $callback;

            if (!class_exists($class)) {
                http_response_code(500);
                echo "Controller '$class' not found.";
                return;
            }

            $controller = new $class();

            if (!method_exists($controller, $method)) {
                http_response_code(500);
                echo "Method '$method' not found in controller '$class'.";
                return;
            }

            $controller->$method($_REQUEST);
        }
    }
}
