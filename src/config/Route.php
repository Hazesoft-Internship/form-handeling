<?php
namespace App\config;
    class Route
    {
        public array $routes = [];
        public function get(string $path, array $callBack): void
        {
            $this->routes['GET'][$path] = $callBack;
        }
        public function post(string $path, array $callBack): void
        {
            $this->routes['POST'][$path] = $callBack;
        }

        public function resolve()
        {
            $method = $_SERVER['REQUEST_METHOD'];
            $path = $_SERVER['REQUEST_URI'];
            $path = explode('?', $path)[0];

            $callBack = $this->routes[$method][$path] ?? null;

            if($callBack == null)
            {
                return "Page not found";
            }

            if($callBack)
            {
                [$class, $method] = $callBack;
                $controller = new $class();
                return $controller->$method();
            }
            return $callBack;
        }
    }
?>