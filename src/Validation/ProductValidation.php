<?php

namespace Hazesoft\Formhandeling\Validation;

use Hazesoft\Formhandeling\Exception\ValidationException;

use Hazesoft\Formhandeling\Validation\Validation;

class ProductValidation extends Validation
{
    public function validateInteger($data): int
    {
        if (empty($data)) {
            throw new ValidationException("Field is required", 204);
        }

        if (!filter_var($data, FILTER_VALIDATE_INT)) {
            throw new ValidationException("Must be a valid integer", 422);
        }

        return (int) $this->test_input($data);
    }


    public function validateForm($data): array
    {
        return [
            'name' => $this->validateString($data['name']),
            'quantity' => $this->validateInteger($data['quantity']),
            'price' => $this->validateInteger($data['price']),
            'types' => $this->validateString($data['types'])
        ];
    }
}
