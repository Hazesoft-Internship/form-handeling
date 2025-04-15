<?php

declare(strict_types=1);

namespace src\Exceptions;

class ValidationException extends CustomException
{
    public function handle(): void
    {
        echo "Validation Error: " . $this->getMessage();
    }
}
