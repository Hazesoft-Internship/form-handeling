<?php

namespace Hazesoft\Formhandeling\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __toString(): string
    {
        return "Error: " . $this->getMessage() . " (Code: " . $this->getCode() . ")";
    }
}
