<?php

namespace App\Models\Product;

use App\Models\Model;

abstract class Product
{
    public string $name;
    public int $quantity;
    public float $price;
    public string $description;
    public int $user_id;

    public function __construct(string $name,  int $quantity, float $price, int $user_id, string $description)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->description = $description;
        $this->user_id = $user_id;
    }

    abstract function getType(): string;
}
