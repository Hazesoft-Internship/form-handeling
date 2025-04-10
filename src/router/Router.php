<?php

declare (strict_types = 1);

namespace ayushtamang\FormHandeling\router;

class Router
{
    private $routes = [];
    public function get(string $path, callable|array $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, callable|array $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function getRoutes($routes)
    {
        foreach ($routes["GET"] ?? [] as $path => $controller) {
            $this->get($path, $controller);
        }
        foreach ($routes["POST"] ?? [] as $path => $controller) {
            $this->post($path, $controller);
        }
    }

    public function resolve(string $path)
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $callback = $this->routes[$requestMethod][$path] ?? null;

        if ($callback === null) {
            http_response_code(404);
            return "404 NOT FOUND";
        }
        if (is_array($callback)) {
            [$class, $method] = $callback;
            $controller = new $class();
            return $controller->$method();
        }
        return $callback();
    }
}