<?php
session_start();
// check to see if the user is logged in
if ($_SESSION['loggedin']) {
require_once 'config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT username FROM accounts WHERE id=" . $_SESSION['id'];
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $username = $row["username"];
    }
} else {
    $username = "Unavailable";
}

} else {
	// user is not logged in, send the user to the login page
	header('Location: index.php');
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Grant Management Dashboard</title>
  <meta name="description" content="Grand Management Dashboard">
  <meta name="author" content="AMAZING">
	<link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' />
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>

<body>
  <div id="sidebar" class="sidebar">
    <div class="sidebar-header">
      <a href=""><img src="images/logo.png"/></a>
    </div>
    <div class="sidebar-menu">
      <button id="dashboard" class="accordion"><i class="fas fa-tachometer-alt"></i>Dashboard</button>
      <div class="panel">
				<a href="dashboard.php" class="sidebar-button"><i class="fas fa-tachometer-alt"></i>Dashboard Home</a>
        <a href="#" class="sidebar-button" id="custom"><i class="fas fa-palette"></i>Customize</a>
      </div>

<button class="accordion"><i class="fas fa-chart-pie"></i>Grants</button>
<div class="panel">
  <a href="#" class="sidebar-button" id="new-grant"><i class="fas fa-plus-circle"></i>New Grant</a>
  <a href="#" class="sidebar-button" id="view-grants"><i class="far fa-eye"></i>View Grants</a>
</div>

<button class="accordion"><i class="fas fa-tasks"></i>Tasks</button>
<div class="panel">
  <a href="#" class="sidebar-button" id="calendar"><i class="fas fa-calendar-alt"></i>Schedule Alert</a>
</div>

<button class="accordion"><i class="fas fa-toolbox"></i>Analytics</button>
<div class="panel">
  <a href="#" class="sidebar-button" id="spending-analyizer"><i class="fas fa-chart-bar"></i>Spending Trends</a>
</div>

<button class="accordion"><i class="fas fa-user"></i>Profile</button>
<div class="panel">
  <a href="#" class="sidebar-button" id="edit-profile"><i class="fas fa-user-edit"></i>Edit Profile</a>
</div>
    </div>

		<a href="logout.php" class="logout-sidebar"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

  <div class="header">
    <div class="header-img">
    </div>
    <div class="expand-button">
      <i class="fas fa-expand" style="color: #263544;" onClick="openFullscreen()"></i>
    </div>
    <div class="search-bar">
			<form id="search-bar-form" style="text-align:right;">
        <i id="search-bar" class="fas fa-search search-bar-icon"></i>
				<input id="search-bar-input" class="search-bar-input" type="search" placeholder="Search Grants...">
				<a href="javascript:clearSearch();"><i id="search-bar-cancel" class="fas fa-times-circle cancel disabled"></i></a>
				<p id="search-bar-cancel-text" class="search-bar-cancel-text disabled"><a href="javascript:cancelSearch();">Cancel<a></p>
			</form>
    </div>
    <div class="header-account-info">
    <div class="header-menu-buttons">
      <i class="fas fa-bell" id="notifications-print" style="margin-right:10px;"></i>
			<div class="notification-dropdown" id="notification-dropdown">
				<i class="fas fa-caret-up fa-2x" style="margin-top:-25px;position: absolute;top: 9px;color: #263544;left: 339px;"></i>
				<div class="notification-header">
					<p><i style="color: #fff;margin-left:6px;margin-right: 6px" class="fas fa-bell fa-sm"></i> Notifications</p>
				</div>
				<div id="notifications" class="notifications">
				</div>
			</div>
      <i class="fas fa-question-circle" style="color: #263544;"></i>
    </div>
    <div class="header-account-username">
      <i class="fas fa-user" style="color: #263544;"></i><?php echo "<a href='account.php'>" . $username . "</a>"?>
    </div>
     <i class="fas fa-caret-down fa-sm" onclick="openDropdown('account-dropdown')" style="color: #263544; margin-top: 4px; cursor: pointer;"></i>
      <div class="account-dropdown" id="account-dropdown">
        <i class="fas fa-caret-up" style="margin-top:-20px;position: absolute;top: 9px;color: white;left: 142px;"></i>
        <a href="#">My Account</a>
        <a href="#">Help</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
    <div class="header-menu-bar">
      <ul>
        <li><a href="#" id="button1">Home</a></li>
        <li><a href="#" onClick="scrollToSection('#description')">New Grant</a></li>
        <li><a href="#" onClick="scrollToSection('#definition')">Link</a></li>
        <li><a href="#" onClick="scrollToSection('#design')">Link</a></li>
      </ul>
    </div>

  </div>

  <div class="main" id="main">
    <div class="breadcrumbs" id="breadcrumbs">
      <p><a href='dashboard.php'><i class="fas fa-home"></i></a> / Dashboard</p>
    </div>
    <div class="content" id="content">
    	<?php include 'includes/dashboard/dashboard.php'; ?>
  </div>
</div>

  <div class="footer">
		<div class="alertbar" id="alertbar"></div>
		<div id="myModal" class="modal">
		<div id="modalTitle" class="modal-title">

		</div>
  	<div id="modalContent" class="modal-content">

  	</div>

</div>
    <div class="footer_text">

    </div>
  </div>


</body>
	<script src="js/moments.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
	<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/0.6.6/chartjs-plugin-zoom.js"></script>
  <script src="js/xlsx.full.min.js"></script>
  <script src="js/Dashboard.js"></script>
</html>
