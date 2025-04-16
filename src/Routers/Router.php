<?php

namespace ECommerce\Routers;

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

    public function loadRoutes($routes)
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
    
        // Case 1: If route has middleware and handler
        if (is_array($route) && isset($route['handler'])) {
            $handler = $route['handler'];
            $middlewares = $route['middleware'] ?? [];
    
            foreach ($middlewares as $middlewareClass) {
                $middleware = new $middlewareClass();
                if (!$middleware->handle()) {
                    return;
                }
            }
    
            // Execute controller
            if (is_array($handler)) {
                [$class, $method] = $handler;
                $controller = new $class();
                return $controller->$method();
            } elseif (is_callable($handler)) {
                return $handler();
            }
        }
    
        // Case 2: Regular controller or closure (no middleware)
        if (is_array($route)) {
            [$class, $method] = $route;
            $controller = new $class();
            return $controller->$method();
        }
    
        // Case 3: Closure
        if (is_callable($route)) {
            return $route();
        }
    }
    
}
