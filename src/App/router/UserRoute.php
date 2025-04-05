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
        $action = $this->pathArray[$routeMethod][$route];
        [$class, $method] = $action;
        if (!$action) {
            echo "action error";
        }
        if (!class_exists($class)) {
            echo "class doesnot exist";
        }
        return call_user_func_array([new $class, $method], []);
    }
}
