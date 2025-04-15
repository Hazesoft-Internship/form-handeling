<?php

namespace src\Config;

class Router {
    private $routes = [];

    public function add(string $method, string $path, string $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $pattern = '#^' . preg_replace('/:(\w+)/', '(?P<$1>[^/]+)', $route['path']) . '$#';
            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                list($controllerName, $action) = explode('@', $route['handler']);
                $controllerClass = "src\\Controllers\\{$controllerName}";
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        $controller->$action($params);
                        return;
                    }
                }
                throw new \Exception("Route handler not found.");
            }
        }
        http_response_code(404);
        echo 'Page not found';
    }
}