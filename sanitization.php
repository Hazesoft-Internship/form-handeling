<?php
class sanitizeInput
{
    public function sanitizer($data)
    {
        $data = htmlspecialchars(trim($data));
        return $data;
    }

    public function getData(){
      $userData = [$_POST["first_name"], $_POST["middle_name"], $_POST["last_name"], $_POST["address"], $_POST["email"]];
      return $userData;
    }
}


require_once 'validation.php';


