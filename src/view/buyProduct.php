<?php

use ayushtamang\FormHandeling\session\Session;

$session = Session::getInstance();
$user = $session->getSession("userLoggedIn");

if (!isset($user)) {
    header("Location: /login");
    exit();
}
?>