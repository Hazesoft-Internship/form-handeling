<?php

namespace ECommerce\Routers;

class Router
{
    private $routes = [];
    public function get(string $path, callable|array $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, callable|array $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function loadRoutes(array $routes): void
    {
        foreach ($routes["GET"] ?? [] as $path => $controller) {
            $this->get($path, $controller);
        }
        foreach ($routes["POST"] ?? [] as $path => $controller) {
            $this->post($path, $controller);
        }
    }

    public function dispatch(string $path)
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $route = $this->routes[$requestMethod][$path] ?? null;

        if ($route === null) {
            http_response_code(404);
            echo "404 NOT FOUND";
            return;
        }

        if (is_array($route) && isset($route['handler'])) {
            $handler = $route['handler'];
            $middlewares = $route['middleware'] ?? [];

            foreach ($middlewares as $middlewareClass) {
                $middleware = new $middlewareClass();
                if (!$middleware->handle()) {
                    return;
                }
            }

            if (is_array($handler)) {
                [$class, $method] = $handler;
                $controller = new $class();
                return $controller->$method();
            } elseif (is_callable($handler)) $handler();
        }

        if (is_array($route)) {
            [$class, $method] = $route;
            $controller = new $class();
            return $controller->$method();
        }

        if (is_callable($route)) $route();
    }
}
