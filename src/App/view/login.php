<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

</head>

<body>
  <h1>Login</h1>
  <form action="/login" method="POST">
    <label>email</label>
    <input type="email" name="email" />
    <label>password</label>
    <input type="password" name="password" />
    <button type="submit">submit</button>
  </form>
  <a href="/"><button>register</button></a>

  <a href="/product"><button>continue as guest</button></a>
</body>

</html>