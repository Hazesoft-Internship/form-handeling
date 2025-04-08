<?php

namespace ECommerce\Utils\Validation;

use ECommerce\Utils\Validation\Validation;
use ECommerce\Utils\Validation\ValidationException;

class ValidateProduct extends Validation
{
    public function validateUserInput(array $inputArr)
    {
        try {
            list($productName, $productPrice, $productQuantity) = $inputArr;

            if ($productPrice <= 0) {
                throw new ValidationException("Price should be greater than 0");
            }
            if ($productQuantity <= 0) {
                throw new ValidationException("Product quantity should be greater than 0");
            }

            return $this->sanitizeInput($inputArr);
        } catch (ValidationException $e) {
            return ["error" => $e->errorMessage()];
        }
    }
}
