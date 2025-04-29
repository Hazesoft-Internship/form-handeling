<?php

session_start();

// Check if the user is logged in, 
if (!isset($_SESSION['email'])) {
    header("Location: /login");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

</head>

<body>
    <header>
        <h1>Welcome to the Dashboard</h1>
        <p>Hello</p>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Overview</h2>
            <p>This is your dashboard where you can manage your account and view important information.</p>
        </section>

        <section>
            <h2>Quick Links</h2>
            <ul>
                <li><a href="/addproduct">Add Products</a></li>

                <li><a href="/productlist"> Products List</a></li>



            </ul>
        </section>
    </main>


</body>

</html>