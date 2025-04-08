<?php

namespace Lattefront\FormHandeling\Controller;



class FormValidation
{

    function validate($data)
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
}
