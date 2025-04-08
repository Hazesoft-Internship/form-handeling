<?php

namespace App\Router;


class Router
{


    protected array $routes;

    public function __construct()
    {
        $this->routes = include(__DIR__ . '/../Config/routes.php');
    }

    public function get(string $uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function route()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $requestUri = explode('?', $requestUri)[0];




        $route = $this->routes[$method][$requestUri] ?? null;







        if (!$route == null) {


            $controller = $route;
            if (is_array($controller)) {
                $class = $controller[0];
                $method = $controller[1];
                $instance = new $class();
                return $instance->$method();
            } else {
                return call_user_func($controller);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
        exit;
    }
}
