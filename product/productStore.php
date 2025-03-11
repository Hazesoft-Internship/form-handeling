<?php

require_once("../config.php");
if (!isset($_SESSION["userLoggedIn"])) {
    header("Location: ../login.php");
    exit();
}
?>



<a href="addProduct.php">Add Product</a>
<a href="../logout.php">logout</a>