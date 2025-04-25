<?php

namespace Hazesoft\Backend\Validations;

use Exception;
use Hazesoft\Backend\Validations\Validation;

class ProductValidation extends Validation
{
    public function validateUserInput(array $inputArray): bool
    {
        try {
            [$productName, $productPrice, $productQuantity] = $inputArray;
            // validation status
            $isValidationOk = 0;

            $isValidationOk += $this->validateName($productName);
            $isValidationOk += $this->validateNumber($productPrice, "Product price");
            $isValidationOk += $this->validateNumber($productQuantity, "Product quantity");

            if ($isValidationOk == 3) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            echo($exception->getMessage());
        }
    }

    public function validateName(string $name): int
    {
        try{
            $name = $this->sanitizeData($name);
            if (empty($name)) {
                echo("Product name is required");
            }
            if (!preg_match("/^[a-zA-Z\d\s]+$/", $name)) {
                echo("Product name can contain only letters and spaces.");
            }
            return 1; // No error
        } catch(Exception $exception){
            echo($exception->getMessage());
        }
        
    }

    public function validateNumber(float $number, string $type): int
    {
        try{
            $number = $this->sanitizeData($number);
            if (empty($number)) {
                echo("{$type} is required");
            }
            if ($number <= 0) {
                echo("{$type} should be greater than 0");
            }
            if (!is_numeric($number)) {
                echo("{$type} should be a valid number");
            }
            return 1; // No error
        } catch (Exception $exception){
            echo($exception->getMessage());
        }
    }
}
