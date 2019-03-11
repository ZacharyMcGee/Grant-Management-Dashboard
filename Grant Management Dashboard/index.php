<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>SIU - Grant Management System</title>
  <meta name="description" content="Grant Management System for Southern Illinois University">
  <meta name="author" content="Zachary McGee/Andrew Duckworth/Andrew Scott/Michael Olson">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/login.css">

</head>

<body>

<div class="content">
  <div class="login-right">
      <form action="auth.php" method="post">
        <a href="index.html"><img src="images\logo.png" style="width:100%;"></a>
        <h1>Login or Sign Up</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter Your Username....">
        <label for="username">Password:</label>
        <input type="password" id="password" name="password" placeholder="********">
              <button type="submit" id="login-button">Login</button>
      </form>
    </div>
  <div class="login-left">
    <div class="left-description">

    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<script src="js/login.js"></script>
</body>
</html>
