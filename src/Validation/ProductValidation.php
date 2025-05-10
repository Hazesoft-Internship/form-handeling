<?php

namespace App\Validation;



class ProductValidation
{

    public function insertProduct(string $name, string $description, float $price, int $quantity, int $user_id)
    {

        if ($name == '' || $description == '' || $price == '' || $quantity == '') {
            die("Missing required fields");
        }

        if (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
            die("Price should be a number");
        }

        if (!filter_var($user_id, FILTER_VALIDATE_INT)) {
            die("Invalid userId");
        }

        if (!filter_var($quantity, FILTER_VALIDATE_INT)) {
            die("Quantity should be a number");
        }
    }
    public function updateProduct(string $name, string $description, float $price, int $quantity)
    {
        if ($name == '' || $description == '' || $price == '' || $quantity == '') {
            die("Updating fields should not be empty!");
        }
    }
}
