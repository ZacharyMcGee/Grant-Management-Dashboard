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
  <div class="login-right">
    <div class="slideshow-container">
      <div class="mySlides fade">
        <img src="images/demo.png" style="width:100%">
        <div class="text">
          <div class="text-header">
            <h1>Easily Track Your Grants</h1>
          </div>
          <div class="text-body">
            <h6>Convert your hard to read wall of excel data into easily readable information</h6>
          </div>
        </div>
      </div>

      <div class="mySlides fade">
        <img src="../images/demo.png" style="width:100%">
        <div class="text">
          <div class="text-header">
            <h1>Automatic Calculations</h1>
          </div>
          <div class="text-body">
            <h6>Automatically calculate your remaining direct and indirect cost numbers</h6>
          </div>
        </div>
      </div>

      <div class="mySlides fade">
        <img src="images/demo.png" style="width:100%">
        <div class="text">
          <div class="text-header">
            <h1>Never Miss A Deadline</h1>
          </div>
          <div class="text-body">
            <h6>Get automatically notified when a deadline is approaching with scheduled alerts</h6>
          </div>
        </div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

  </div>
<br>

  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>
</div>
  <div class="login-left">
    <form action="../auth.php" method="post">
      <div class="login-left-header">
        <a href="index.php"><img src="../images\logo.png"></a>
      </div>
      <div class="input-icon"><i class="fas fa-user"></i></div>
      <input type="text" id="username" name="username" placeholder="Username">
      <div class="input-icon"><i class="fas fa-lock"></i></div>
      <input type="password" id="password" name="password" placeholder="Password">
      <button type="submit" id="login-button">Login</button>
      <h6>Don't have an account? <a href="signup.php">Sign up.</a></h6>
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
