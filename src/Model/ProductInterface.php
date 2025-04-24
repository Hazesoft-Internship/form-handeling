<?php 
namespace Lattefront\FormHandeling\Model;


interface ProductInterface{
    public static function getPaymentMethod():array;
    public static function getDiscountedPrice($quantity,$price):int;
    public static function getProductTypes(): string;
}