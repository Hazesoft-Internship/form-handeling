<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\User\UserModel;
use App\Sessions\Sessions;
use App\Validation\UserValidation;
use App\Controllers\Product\ProductController;


class UserController extends Controller
{

    public $validation;
    public function __construct()

    {
        parent::__construct();
        $this->validation = new UserValidation();
    }

    public function homePage()
    {
        require_once __DIR__ . ' /../../Views/home.php';
    }

    public function landingPage()
    {
        $loggedIn = (Sessions::getInstance())->hasSession('user');
        $products = (new ProductController())->listProducts();

        if (empty($products)) {
            echo "No products found.";
            return;
        }
        require_once __DIR__ . '/../../Views/landingPage.php';
    }
    public function loginPage()
    {
        require_once __DIR__ . '/../../Views/login.php';
    }
    public function registerPage()
    {
        require_once __DIR__ . '/../../Views/signup.php';
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
