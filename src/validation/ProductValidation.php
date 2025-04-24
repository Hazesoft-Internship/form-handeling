<?php

namespace App\validation;

require_once __DIR__."/../../vendor/autoload.php";

use App\validation\Validation;

class ProductValidation extends Validation
{

    public array $error = [];
    public function __construct(
        private string $productName,
        private float $productPrice,
        private int $productQuantity) {}

    // public function read()
    // {
    //     $this->productName = htmlspecialchars($_POST['productName']);
    //     $this->productPrice = htmlspecialchars($_POST['productPrice']);
    //     $this->productQuality = htmlspecialchars($_POST['productQuantity']);
    // }

    public function validate()
    {
        if(!validateText($this->productName))
        {
            $this->error['productName'] = "Invalid Name for given Product: ";
        }

        // if(!(is_float($this->productPrice))
        // {
        //     $this->error['product'] = "Invalid Price for product: ";
        // }

        if(!is_integer($this->productQuantity))
        {
            $this->error['productQuantity'] = "Invalid quantity for given Product: " .$this->productName;
        }
    }
}
