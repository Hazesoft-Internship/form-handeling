<?php

namespace Lattefront\FormHandeling\Router;

class Router
{

    protected $routes = [];
    public function __construct()
    {
        // Load routes from the configuration file
        $this->routes = require __DIR__ . '/../../config/routerConfig.php';
       
    }

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
    public function dispatch()
        
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = explode('?', $path)[0];
        
        $callback = $this->routes[$method][$path] ?? null;
        
        if ($callback === null) {
            http_response_code(404);
            echo "404 Route Not Found";
        }
        
        if (is_array($callback)) {
            [$class, $method] = $callback;
            $controller = new $class();
            return $controller->$method();
        }
        
        return $callback();
    }
}
