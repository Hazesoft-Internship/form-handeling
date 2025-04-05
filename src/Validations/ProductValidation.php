<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\Validation;
//use Hazesoft\Backend\Validations\Exception as Exception;

class ProductValidation extends Validation
{
    public function validateUserInput(array $inputArray)
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
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validateName(string $name)
    {
        try{
            $name = $this->sanitizeData($name);
            if (empty($name)) {
                throw new ValidationException("Product name is required");
            }
            if (!preg_match("/^[a-zA-Z\d\s]+$/", $name)) {
                throw new ValidationException("Product name can contain only letters and spaces.");
            }
            return 1; // No error
        } catch(Exception $exception){
            throw new ValidationException($exception->getMessage());
        }
        
    }

    public function validateNumber(float $number, string $type)
    {
        try{
            $number = $this->sanitizeData($number);
            if (empty($number)) {
                throw new ValidationException("{$type} is required");
            }
            if ($number <= 0) {
                throw new ValidationException("{$type} should be greater than 0");
            }
            if (!is_numeric($number)) {
                throw new ValidationException("{$type} should be a valid number");
            }
            return 1; // No error
        } catch (Exception $exception){
            throw new ValidationException($exception->getMessage());
        }
    }
}
