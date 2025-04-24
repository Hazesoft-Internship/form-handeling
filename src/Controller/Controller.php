<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Session\Session;


class Controller
{
    protected Session $session;
    public function __construct(){
        $this->session = Session::getInstance();
    }
    
}