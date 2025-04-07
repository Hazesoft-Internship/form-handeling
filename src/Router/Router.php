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
        $this->routes[] = [
            'url' => $uri,
            'controller' => $controller,
            'method' => 'GET',
        ];
    }

    public function post($uri, $controller)
    {
        $this->routes[] = [
            'url' => $uri,
            'controller' => $controller,
            'method' => 'POST',
        ];
    }

    public function route()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];



        foreach ($this->routes as $route) {

            if ($requestUri == $route['url'] && $method == $route['method']) {

                $controller = $route['controller'];
                if (is_array($controller)) {
                    $class = $controller[0];
                    $method = $controller[1];
                    $instance = new $class();
                    return $instance->$method();
                } else {
                    return call_user_func($controller);
                }
            }
        }
        http_response_code(404);
        echo "404 Not Found";
        exit;
    }
}
