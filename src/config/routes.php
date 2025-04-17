<?php

use ayushtamang\FormHandeling\controls\user_controls\UserControls;
use ayushtamang\FormHandeling\controls\product_controls\ProductControls;
use ayushtamang\FormHandeling\controls\cart_controls\CartControls;

return [
    "GET" => [
        "/" => [UserControls::class, "getRegister"],
        "/login" => [UserControls::class, "getLogin"],
        "/logout" => [UserControls::class, "getLogout"],
        "/product" => [ProductControls::class, "getProductStore"],
        "/product/add" => [ProductControls::class, "getAddProduct"],
        "/product/profile" => [ProductControls::class, "getProductProfile"],
        "/product/profile/update" => [ProductControls::class, "getProductUpdate"],
        "/product/buy" => [ProductControls::class, "getProductBuy"],
        "/product/cart" => [CartControls::class, "getCart"],
        "/product/cart/update" => [CartControls::class, "getUpdateCart"],
    ],
    "POST" => [
        "/registerSubmit" => [UserControls::class, "registerSubmit"],
        "/loginSubmit" => [UserControls::class, "loginSubmit"],
        "/product/addSubmit" => [ProductControls::class, "addProductSubmit"],
        "/product/profile/updateSubmit" => [ProductControls::class, "updateProductSubmit"],
        "/product/profile/deleteSubmit" => [ProductControls::class, "deleteProductSubmit"],
        "/product/buy/addcartsubmit" => [CartControls::class, "addCartSubmit"],
        "/product/cart/updateSubmit" => [CartControls::class, "updateCartSubmit"],
        "/product/cart/deleteSubmit" => [CartControls::class, "deleteCartSubmit"],
    ]
];
?>