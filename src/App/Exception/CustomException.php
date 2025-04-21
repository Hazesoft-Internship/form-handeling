<?php

namespace App\Exception;

class CustomException extends \Exception
{
    public function __construct(protected array $errors, protected $message = "Validation Error", protected $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getTheError(): array
    {
        return $this->errors;
    }
}
