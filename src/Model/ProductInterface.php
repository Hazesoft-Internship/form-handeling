<?php 
namespace Lattefront\FormHandeling\Model;


interface ProductInterface{
    public  function getPaymentMethod():array;
    public  function getDiscountedPrice():int;
    public  function getProductTypes(): string;
}