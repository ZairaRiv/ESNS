<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="CSS/styleLogin.css">
</head>
<body>
    <div class="loginBox">
        <img src="img/user.png" class="user">
        <h2>Log In Here</h2>
        <form action="process.php" method="POST">
          <p>Username</p>
          <input type="text" id='user' name="user" placeholder="Enter your username">
          <p>Password</p>
          <input type="password" id='pass' name="pass" placeholder="**********"><br>
          <input type="submit" name="submit" value="Log In"><br>
          <a href="#">Forget Password</a>
        </form>
    </div>
</body>
</html>