<?php

namespace Lattefront\FormHandeling\Model;

use Lattefront\FormHandeling\Model\ProductInterface;

class Physicalproduct implements ProductInterface// need to extend products
{
    private $price;
    private $quantity;
    private $totalprice = 0;
    public function __construct(public  $product) {
        $this->price = $product['price'];
        $this->quantity = $product['quantity'];
        $this->totalprice = $this->price * $this->quantity;
    }
    public  function getPaymentMethod(): array
    {
        return [(string) "COD", (string) "Esewa"];
    }

    public function  getDiscountedPrice(): int
    {
        if ($this->quantity >= 5 && $this->quantity < 10) {
            $this->totalprice += 100;
        }
        if ($this->quantity >= 10) {
            $this->totalprice += 200;
        }
        return $this->totalprice;
    }

    public  function getProductTypes(): string
    {
        return "Physical";
    }
}
