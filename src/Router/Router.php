<?php

namespace Lattefront\FormHandeling\Router;

class Router
{

    protected $routes = [];

    protected function add($method, $uri, $controller): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method

        ];
    }

    public function getId($uri, $controller): void
    {
        $uri = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $uri);
        $this->add('GET', $uri, $controller);
    }
    public function get($uri, $controller): void
    {
        $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller): void
    {
        $this->add('POST', $uri, $controller);
    }
    public function put($uri, $controller): void
    {
        $this->add('PUT', $uri, $controller);
    }
    public function patch($uri, $controller): void
    {
        $this->add('PATCH', $uri, $controller);
    }
    public function delete($uri, $controller): void
    {
        $this->add('DELETE', $uri, $controller);
    }
    public function dispatch(): void
    {
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        //  echo "Request URI: " . $requestUri . "<br>";
        // echo "Request Method: " . $requestMethod . "<br>";

        foreach ($this->routes as $route) {
            if ($route['uri'] === '/' . $requestUri && $route['method'] ===  $requestMethod) {

                if (is_callable($route['controller'])) {
                    call_user_func($route['controller']);
                } elseif (is_array($route['controller'])) {
                    // Handle the controller and method if they are passed as an array
                    list($controllerClass, $method) = $route['controller'];
                    $controllerInstance = new $controllerClass();

                    if (method_exists($controllerInstance, $method)) {
                        call_user_func([$controllerInstance, $method]);
                    } else {
                        echo "Method '$method' not found in '$controllerClass'.<br>";
                    }
                }

                return;
            }
        }

        http_response_code(404);
        echo "Route Not Found";
    }
}
