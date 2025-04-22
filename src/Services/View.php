<?php

namespace Hazesoft\Formhandeling\Services;

class View
{
    public static function render(string $viewName, array $data = []): void
    {
        extract($data);

        $viewPath = __DIR__ . "/../views/{$viewName}.php";

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View file {$viewName}.php not found!";
        }
    }
}
