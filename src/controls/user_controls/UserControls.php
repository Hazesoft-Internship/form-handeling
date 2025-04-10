<?php

namespace ayushtamang\FormHandeling\controls\user_controls;

use ayushtamang\FormHandeling\model\Authentication;
use ayushtamang\FormHandeling\controls\Sanitizer;
use ayushtamang\FormHandeling\session\Session;
use ayushtamang\FormHandeling\database\Database;

class UserControls
{
    private $con, $session, $user;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->con = $db->getConnection();
        $this-> user = new Authentication($this->con);
        $this->session = Session::getInstance();
    }

    public function getRegister()
    {
        require __DIR__ . "/../../view/register.php";
    }

    public function getLogin()
    {
        require __DIR__ . "/../../view/login.php";
    }

    public function getLogout()
    {
        require __DIR__ . "/../../view/logout.php";
    }

    public function registerSubmit()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $fn = Sanitizer::sanitizeString($_POST["firstname"]);
            $mn = Sanitizer::sanitizeString($_POST["middlename"]);
            $ln = Sanitizer::sanitizeString($_POST["lastname"]);
            $add = Sanitizer::sanitizeString($_POST["address"]);
            $em = Sanitizer::sanitizeEmail($_POST["email"]);
            $pw = Sanitizer::sanitizePassword($_POST["password"]);
            
            try {
                if($this->user->register($fn, $mn, $ln, $add, $em, $pw)) {
                    header("Location: /login");
                } else {
                    echo "Failed to insert data!";
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function loginSubmit()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $em = Sanitizer::sanitizeEmail($_POST["email"]);
            $pw = Sanitizer::sanitizePassword($_POST["password"]);
            
            try {
                if($this->user->login($em, $pw)) {
                    $this->session->setSession("userLoggedIn", $em);
                    header("Location: /product");
                } else {
                    echo "Failed to login!";
                }
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>