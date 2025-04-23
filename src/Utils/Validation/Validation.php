<?php

namespace ECommerce\Utils\Validation;

abstract class Validation
{
    protected $patternName = "/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/";
    protected $patternEmail = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    protected $patternPassword = "/^.{6,}$/";

    protected function sanitizeInput(array $inputArr): array
    {
        return array_map(function (string $userData) {
            $userData = trim($userData);
            return htmlspecialchars($userData);
        }, $inputArr);
    }

    abstract function validateUserInput(array $inputArr);
}
