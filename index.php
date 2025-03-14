
  <?php

  require_once 'User.php';
  require_once 'DbConnect.php';
  require_once 'Validate.php';



  $connecton = DBConnect::getInstance("localhost", "php", "password", "testdb")->createConnection();


  if ($connecton->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];



    if (Validate::validate($first_name, $middle_name, $last_name, $email, $address)) {
      $user = new User($first_name, $middle_name, $last_name, $email, $address);
      $user->insertUser($connecton);
    }
  }
