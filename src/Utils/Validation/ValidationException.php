<?php

namespace ECommerce\Utils\Validation;

use Exception;

class ValidationException extends Exception
{
    public function errorMessage(): string
    {
        return "Validation Error: " . $this->getMessage();
    }
}
