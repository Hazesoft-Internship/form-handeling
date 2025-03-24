<?php

namespace HazeSoft\Backend\formHandeling\utils;

use Exception;

class ValidationException extends Exception
{
    public function errorMessage(): string
    {
        return "Validation Error: " . $this->getMessage();
    }
}
