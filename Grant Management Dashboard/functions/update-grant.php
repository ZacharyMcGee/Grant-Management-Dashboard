<?php
session_start();
require_once '../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Get current user
$userId = $_SESSION['id'];
$currentGrant = $_SESSION['current_grant'];

// Get POST values
$jsondata = json_encode($_POST['jsondata']);

$sql2 = "SELECT jsondata, creation_date FROM grants WHERE id=" . $currentGrant;
$result = $con->query($sql2);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $old_json = $row['jsondata'];
  $old_date = $row['creation_date'];

  $sql3 = "INSERT INTO grant_archive (grantid, jsondata, creation_date)
  VALUES ($currentGrant, '$old_json', '$old_date')";

  if ($con->query($sql3) === TRUE) {
      echo "Successfuly updated grant: " . $_SESSION['current_grant'];
  } else {
      echo "Error updating record: " . $con->error;
  }
}

$sql = "UPDATE grants SET jsondata='$jsondata' WHERE id=" . $_SESSION['current_grant'];
$sql4 = "UPDATE grants SET creation_date=now() WHERE id=" . $_SESSION['current_grant'];
if ($con->query($sql) === TRUE) {
    $con->query($sql4);
    echo "Successfuly updated grant: " . $_SESSION['current_grant'];
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
