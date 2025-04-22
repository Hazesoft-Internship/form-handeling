<?php

namespace Hazesoft\Formhandeling\Core;

class Request
{
    public function getPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getBody(): array
    {
        $body = [];
        if ($this->method() == 'POST') {
            foreach ($_POST as $key => $value) {
                $body[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        return $body;
    }
}
