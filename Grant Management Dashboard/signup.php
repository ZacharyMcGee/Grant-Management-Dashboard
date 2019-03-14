<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>SIU - Grant Management System</title>
  <meta name="description" content="Grant Management System for Southern Illinois University">
  <meta name="author" content="Zachary McGee/Andrew Duckworth/Andrew Scott/Michael Olson">
  <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' />
  <link rel="stylesheet" href="css/login.css">

</head>

<body>

<div class="content">
  <div class="signup">
    <form action="functions/create-account.php" method="post">
      <div class="signup-header">
        <a href="index.php"><img src="images\logo.png"></a>
      </div>
      <div class="input-icon"><i class="fas fa-user"></i></div>
      <input type="text" id="username" name="username" placeholder="Username">

      <div class="input-icon"><i class="fas fa-envelope"></i></div>
      <input type="text" id="email" name="email" placeholder="Email Address">

      <div class="input-icon"><i class="fas fa-lock"></i></div>
      <input type="password" id="password" name="password" placeholder="Enter Password">

      <div class="input-icon"><i class="fas fa-lock"></i></div>
      <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">

      <button type="submit" id="login-button">Sign Up Now</button>
      <h6>Already have an account? <a href="index.php">Log in.</a></h6>
    </form>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<script src="js/login/slideshow.js"></script>
</body>
</html>
