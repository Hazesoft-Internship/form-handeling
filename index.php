<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
  case '/':
  case '/index.php':
    require __DIR__ . '/views/login.html';
    break;

  case '/signup':
    require __DIR__ . '/views/signup.php';
    break;

  case '/product-store':
    require __DIR__ . '/views/product-store.php';
    break;

  default:
    http_response_code(404);
    echo "404 Not Found";
    break;
}
