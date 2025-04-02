<?php
session_start();
session_unset();
session_destroy();

header("Location: /form-handeling/src/App/view/login.html");
?>