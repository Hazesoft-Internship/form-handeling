<?php
require_once("./config/database.php");
require_once("./src/FormHandler.php");
require_once("./src/FormValidator.php");
require_once("./src/NameSeperator.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$form = new FormHandler();
$form->insert("data/users.csv");
