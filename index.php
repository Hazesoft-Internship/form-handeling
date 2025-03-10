<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Handle</title>
</head>

<body>
  <form action="formHandler.php" method="post">
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required /><br /><br />

    <label for="middleName">Middle Name:</label>
    <input type="text" id="middleName" name="middleName" required /><br /><br />

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required /><br /><br />

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required /><br /><br />

    <label for="email">Address:</label>
    <input type="text" id="address" name="address" required /><br /><br />
    <input type="submit" value="Submit" />
  </form>
</body>

</html>