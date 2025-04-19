<?php

namespace Lattefront\FormHandeling\Service;



class FormValidation
{

   public static function validateUser($data): array
    {
        
        $errors = [];

        // Validate first name
        if (preg_match('/[^a-zA-Z]/', $data[0])) {
            $errors[] = 'First name should be in alphabets';
        }

        // Validate middle name if not empty
        if (!empty($data[1]) && preg_match('/[^a-zA-Z ]/', $data[1])) {
            $errors[] = 'Middle name should be in alphabets';
        }

        // Validate last name
        if (preg_match('/[^a-zA-Z]/', $data[2])) {
            $errors[] = 'Last name should be in alphabets';
        }

        // Validate address
        if (preg_match('/[^a-zA-Z0-9\s]/', $data[3])) {
            $errors[] = 'Address should be alphanumeric';
        }

        // Validate email
        if (!filter_var($data[4], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        return $errors;
    }

    static function validateProduct($data): array
    { 
        $errors = []; 

       
    
        // Validate product name
        if (preg_match('/[^a-zA-Z0-9 ]/', $data[0])) {
            $errors[] = 'Product name should be alphanumeric';
        }

        // Validate product quantity
        if (!is_numeric($data[1]) || $data[1] <= 0) {
            $errors[] = 'Product quantity should be a positive number';
        }

        // Validate product price
        if (!is_numeric($data[2]) || $data[2] <= 0) {
            $errors[] = 'Product price should be a positive number';
        }

        // Validate product description
        if (preg_match('/[^a-zA-Z0-9\s.,]/', $data[3])) {
            $errors[] = 'Product description should be alphanumeric and can include ., ';
        }

        return $errors;
    }
}
