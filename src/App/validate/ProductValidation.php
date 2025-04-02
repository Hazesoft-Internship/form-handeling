<?php

namespace App\validate;
require("../Exception/Exception.php");
use App\Exception\CustomException;

class ProductValidation
{
    private $errors = [];
    public function validator(array $datas)
    {
        if(empty($datas["name"])) {
            $this->errors["name"] = "name should not be empty";
        }
        if(empty($datas["quantity"])) {
            $this->errors["quantity"] = "quantity should not be empty";
        } elseif ($datas["quantity"] < 0) {
            $this->errors["quantity"] = "quantity cannot be less than 0";
        }

        if(empty($datas["price"])) {
            $this->errors["price"] = "price should not be empty";
        } elseif ($datas["price"] < 0) {
            $this->errors["price"] = "price cannot be less than 0";
        }


        if(!empty($this->errors)) {
            throw new CustomException($this->errors);
        }
    }
}
