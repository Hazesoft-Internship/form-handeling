<?php

namespace Hazesoft\Backend\Routers;

class Router {
    private array $routes = [];

    public function get(string $path, callable|array $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, callable|array $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function loadRoutes($routes): void
    {
        foreach ($routes["GET"] ?? [] as $path => $controller){
            $this->get($path, $controller);
        }

        foreach ($routes["POST"] ?? [] as $path => $controller){
            $this->post($path, $controller);
        }
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        $path = explode('?', $path)[0];

        $callback = $this->routes[$method][$path] ?? null;

        if($callback === null) {
            http_response_code(404);
            return "404 Not Found";
        }

        if(is_array($callback)){
            [$class, $method] = $callback;
            $controller = new $class;
            return $controller->$method();
        }

        return $callback();
    }
}