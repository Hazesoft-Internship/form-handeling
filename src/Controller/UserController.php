<?php

namespace Lattefront\FormHandeling\Controller;



class UserController
{
    public function dashboard(): void
    {
        require __DIR__ . '/../View/dashboard.php';
    }
}
