<?php

require __DIR__ . '/../vendor/autoload.php';

$controller = $_GET['controller'] ?? 'Product';
$action = $_GET['action'] ?? 'index';

$controllerClass = "App\\Controllers\\{$controller}Controller";

try {
    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            throw new Exception("Method '$action' not found!");
        }
    } else {
        throw new Exception("Controller '$controllerClass' not found!");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
