<?php

namespace Hazesoft\Formhandeling\Validation;

use Hazesoft\Formhandeling\Exception\ValidationException;

class Validation
{
    public function test_input($data): string
    {
        return htmlspecialchars(trim($data));
    }

    public function validateString($data): string
    {

        if (empty($data)) {
            throw new ValidationException("Field is required", 204);
        }
        if (!preg_match("/^[a-zA-Z-' ]*$/", $data)) {
            throw new ValidationException("Can only contain letters and white space", 422);
        }
        return $this->test_input($data);
    }
}
