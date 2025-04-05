<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

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
            throw new ValidationException($exception->getMessage());
        }
    }

    public function sanitizeArray($array)
    {
        try {
            $sanitizedArray = array_map([$this, 'sanitizeData'], $array);
            return $sanitizedArray; 
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    abstract function validateUserInput(array $inputArray);
}
