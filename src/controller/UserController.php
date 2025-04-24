<?php

namespace App\controller;

require_once __DIR__."/../../vendor/autoload.php";
use App\validation\UserValidation;
use App\session\session;
use App\Model\Database;
use App\Model\User;

class UserController
{
    private $user1;
    public function __construct()
    {
        $this->user1 = new User();
    }
    // returns the login page(Default page)
    public function getLogin(): int
    {
        return require_once __DIR__."/../View/login.html";
    }

    //handles the login logic for the pre-registered user.
    public function handlelogin(): void
    {
        $email = $_POST["email"];
        session::getInstance()->set("email", $email);
        $password = $_POST["password"];
        $this->user1->handlelogin($email, $password);
    }

    // redirects to the productMangement page to operate on the products
    public function getproductManagement(): int
    {
        $userName = strtoupper(session::getInstance()->get("userName"));
        return require_once __DIR__."/../View/productManagement.php";
    }

    // returns the signup page for the user
    public function getSignUp(): int
    {
        return require_once __DIR__."/../View/signup.html";
    }

    //this funciton uploads the newly created user to the Database.
    public function handleSignUp(): void
    {
        $UserValidate1 = new UserValidation();
        $UserValidate1->read();
    }

    //creates the new user to database
    public function uploadUser($firstName, $middleName, $lastName, $address, $email, $password): void
    {
        $this->user1->uploadUser($firstName, $middleName, $lastName, $address, $email, $password);
    }

    //destroys session on logout
    public function handleLogOut(): void
    {
        session::getInstance()->destroySession();
    }
}
?>
