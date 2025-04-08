<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Sessions\Sessions;
use App\Validation\UserValidation;


class UserController
{

    public $validation;
    public  $session;
    public function __construct()

    {
        $this->validation = new UserValidation();
        $this->session = Sessions::getInstance();
    }


    public function logout()
    {



        if (

            $this->session->hasSession('user')
        ) {
            $this->session->removeSession('user');
            $this->session->clearSession();
            header("Location: /login");
            exit();
        } else {
            die("You are not logged in.");
        }
    }

    public function registerUser()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }
        $first_name = $_POST['first_name'] ?? '';
        $middle_name = $_POST['middle_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        $password = $_POST['password'] ?? '';

        $confirm_password = $_POST['confirm_password'] ?? '';


        $this->validation->signup($first_name, $middle_name, $last_name, $email, $address, $password, $confirm_password);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $user = new UserModel();

        $user->signup($first_name, $middle_name, $last_name, $email, $address, $hashed_password);
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';


        $this->validation->login($email, $password);


        $user = new UserModel();
        $user->login($email, $password);

        if ($this->session->hasSession('user')) {
            header("Location: /home");
            exit();
        } else {
            die("Login failed!");
        }
    }
}
