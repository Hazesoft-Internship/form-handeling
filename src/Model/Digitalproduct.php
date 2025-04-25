<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Model\ProductInterface;


class Digitalproduct implements ProductInterface // need to extend products
{

    private $quantity;
    private $price;
    private $totalprice = 0;
    public function __construct(public $product) {

        print_r($product);

        $this->quantity = $product['quantity'];
        $this->price = $product['price'];
        $this->totalprice = $this->price * $this->quantity;
     // die();
    }


    public  function  getPaymentMethod(): array
    {
        return [(string) "Khalti"];
    }

    public  function getDiscountedPrice(): int
    {
        // if ($this->quantity >= 6 & $this->quantity < 12) {
        if ($this->quantity >= 6 & $this->quantity < 12) {

            $this->totalprice -= $this->totalprice * 10 / 100;

            return $this->totalprice;
        }
        if ($this->quantity >= 12) {
            $this->totalprice -= $this->totalprice * 20 / 100;
            return $this->totalprice;
        } else {
            return $this->totalprice;
        }
    }
    public  function getProductTypes(): string
    {
        return "Digital";
    }
}
