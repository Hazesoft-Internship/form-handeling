<?php

namespace Lattefront\FormHandeling\Controller;

use Lattefront\FormHandeling\Model\UserModel;
use Lattefront\FormHandeling\Db\DbConnection;
class UserController
{

    public function insertUser(): void
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
            $db = new DbConnection();

            $userModel = new UserModel($db);

            // Register user and handle response
            $result = $userModel->registerUser($_POST);

            if ($result['success']) {
                echo $result['message'];
                header("Refresh:2; url=/login");
            } else {
                echo $result['message'];
            }
        } else {
            // If it's not a POST request, show the registration form
            echo "Invalid request method. Redirecting to signup page... ";
            header("Refresh:2; url=/signup");

        }
    }

    public function dashboard(): void
    {   
        require __DIR__ . '/../View/dashboard.php';
    }
}
