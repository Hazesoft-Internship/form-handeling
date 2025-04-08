<?php
use Lattefront\FormHandeling\Controller\Controllers;
    return [
        
            'GET' => [
               '/' => [Controllers::class, 'getallproduct'],
                '/dashboard' => [Controllers::class, 'dashboard'],
                '/signup' => [Controllers::class, 'signUp'],
                '/login' => [Controllers::class, 'loginpage'],
                '/addproduct' => [Controllers::class, 'addproductpage'],
                '/logout' => [Controllers::class, 'logout'],
                '/productlist' => [Controllers::class, 'myproductlist'],
                '/viewallproducts' => [Controllers::class, 'getallproduct'],
                '/updateproduct' => [Controllers::class, 'updateproductpage'], 
            ],
            'POST' => [
                '/signup' => [Controllers::class, 'insertUser'],
                '/login' => [Controllers::class, 'login'],
                '/addproduct' => [Controllers::class, 'addproduct'],
                '/updateproduct' => [Controllers::class, 'updateproduct'],
                '/deleteproduct' => [Controllers::class, 'deleteproduct'],
            ]
        
    ];
