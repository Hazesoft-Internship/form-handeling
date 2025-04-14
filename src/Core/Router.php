<?php

namespace Hazesoft\Formhandeling\Core;

class Router
{
    private $request;
    private $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $method = $this->request->method();
        $requestedPath = $this->request->getPath();

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        foreach ($this->routes[$method] as $routePath => $callback) {
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $routePath);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $requestedPath, $matches)) {
                array_shift($matches); // Remove full match

                if (is_array($callback)) {
                    [$controller, $methodName] = $callback;

                    if (!class_exists($controller)) {
                        http_response_code(500);
                        echo "Controller '$controller' not found";
                        return;
                    }

                    $controllerInstance = new $controller();

                    if (!method_exists($controllerInstance, $methodName)) {
                        http_response_code(500);
                        echo "Method '$methodName' not found in controller '$controller'";
                        return;
                    }

                    return call_user_func_array([$controllerInstance, $methodName], $matches);
                }

                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
