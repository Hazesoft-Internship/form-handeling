<?php

namespace App\router;


class UserRoute
{
    private array $pathArray;

    public function get(string $path, array $method)
    {
        $this->pathArray["GET"][$path] = $method;
        return $this;
    }

    public function post(string $path, array $method)
    {
        $this->pathArray["POST"][$path] = $method;
        return $this;
    }

    public function handle()
{
    $url = $_SERVER["REQUEST_URI"];
    $routeMethod = $_SERVER["REQUEST_METHOD"];
    $route = explode("?", $url)[0];

    if (!isset($this->pathArray[$routeMethod][$route])) {
        http_response_code(404);
        echo "404 Not Found: $route";
        return;
    }

    $action = $this->pathArray[$routeMethod][$route];
    [$class, $method] = $action;

    if (!class_exists($class)) {
        echo "Class $class does not exist";
        return;
    }

    if (!method_exists($class, $method)) {
        echo "Method $method does not exist in class $class";
        return;
    }

    return call_user_func_array([new $class, $method], []);
}

}
