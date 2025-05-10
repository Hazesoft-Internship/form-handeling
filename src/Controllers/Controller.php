<?php

namespace App\Controllers;

use App\Sessions\Sessions;

class Controller
{

    public object $session;

    public function __construct()
    {
        $this->session = Sessions::getInstance();
    }
}
