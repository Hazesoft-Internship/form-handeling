<?php

namespace Lattefront\FormHandeling\Controller;


use Lattefront\FormHandeling\Session\Session;
use Lattefront\FormHandeling\Model\UserModel;
use Lattefront\FormHandeling\Db\DbConnection;
use Lattefront\FormHandeling\Service\FormValidation;
use Lattefront\FormHandeling\Service\CartService;


class AuthController
{
    private Session $session;
    private function checkLoggedIn(): void
    {
        $this->session = Session::getInstance();
        if ($this->session->isLoggedIn()) {
            header("Location: /dashboard");
            exit;
        }
    }
    public function signUp(): void
    {
        $this->checkLoggedIn();
        require __DIR__ . '/../View/Signup.php';
    }
    public function insertUser(): void
    {

        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $First_name = strip_tags($_POST['First_name'],);
                $Middle_name = strip_tags($_POST['Middle_name']);
                $Last_name = strip_tags($_POST['Last_name']);
                $Address = strip_tags($_POST['Address']);
                $Email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
                $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Hash the password



                $userModel = new UserModel(new DbConnection());

                $errors = FormValidation::validateUser([$First_name, $Middle_name, $Last_name, $Address, $Email, $Password]);
                if ($errors) {
                    foreach ($errors as $error) {
                        echo $error . "<br>";
                    }
                    return;
                }
                // Register user and handle response
                $result = $userModel->registerUser($First_name, $Middle_name, $Last_name, $Address, $Email, $Password);

                if ($result['success']) {
                    echo $result['message'];
                    header("Refresh:2; url=/login");
                } else {
                    echo $result['message'];
                }
            } else {

                echo "Invalid request method. Redirecting to signup page... ";
                header("Refresh:2; url=/signup");
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            header("Refresh:2; url=/signup");
        }
    }

    public function loginpage(): void
    {
        $this->checkLoggedIn();
        require __DIR__ . '/../View/loginpage.php';
    }
    public function login(): void
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST['Email'];
                $password = $_POST['Password'];
                $this->session = Session::getInstance();
                $login = new UserModel(new DbConnection());
                $login->loginUser($email, $password);

                $cartservice = new CartService(new DbConnection(), $this->session);
                $cartservice->migrateFromSession();

                header("Refresh:1; url=/dashboard");
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            header("Refresh:2; url=/login");
        }
    }
    public function logout(): void
    {
        $this->session = Session::getInstance();
        $this->session->logout();
        header("Location: /login");
        exit;
    }
}
