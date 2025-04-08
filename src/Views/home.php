<?php

use App\Sessions\Sessions;


$session = new Sessions;
if (!$session->hasSession('user')) {
  header("Location: /login");
  exit();
}


// echo $session->getSession('user');
echo session_encode();


// foreach ($session->getSession('user') as $key => $value) {
//   echo $key . ":" . $value;
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
</head>

<body>
  <h1>Home</h1>
  <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?>!</p>
  <form action="/logout" method="POST">
    <button type="submit" name="logout">Logout</button>
  </form>

</body>

</html>