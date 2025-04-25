<?php

namespace Hazesoft\Backend\Validations;

use Exception;

abstract class Validation
{
    private $sanitize;

    public function sanitizeData($data): string|null
    {
        try {
            $data = trim($data);
            $data = htmlspecialchars($data);
            return $data;
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    public function sanitizeArray($array): array
    {
        try {
            $sanitizedArray = array_map([$this, 'sanitizeData'], $array);
            return $sanitizedArray; 
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    abstract function validateUserInput(array $inputArray);
}
