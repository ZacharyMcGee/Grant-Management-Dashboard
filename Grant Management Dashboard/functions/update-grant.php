<?php
session_start();
require_once '../config.php';

// Connect to DB
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Get current user
$userId = $_SESSION['id'];
// Get current grant
$currentGrant = $_SESSION['current_grant'];
// Get POST values
$jsondata = json_encode($_POST['jsondata']);

// First query will get the current grant information
$sql_getcurrentinfo = "SELECT jsondata, creation_date FROM grants WHERE id=" . $currentGrant;
$result = $con->query($sql_getcurrentinfo);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $old_json = $row['jsondata'];
  $old_date = $row['creation_date'];

  // Second query will take the current grant info and create an archive
  $sql_createarchive = "INSERT INTO grant_archive (grantid, jsondata, creation_date, archive_date)
  VALUES ($currentGrant, '$old_json', '$old_date', now())";

  if ($con->query($sql_createarchive) === TRUE) {
    // Get the new data and insert into the current grant
		$sql_updatecurrentdata = "UPDATE grants SET jsondata='$jsondata', last_update=now() WHERE id=" . $_SESSION['current_grant'];

    if ($con->query($sql_updatecurrentdata) === TRUE)
    {
        echo "Successfuly updated grant!";
    }
    else
    {
        echo "Error updating record: " . $con->error;
    }
  }
  else
  {
      echo "Error updating record: " . $con->error;
  }
}

$con->close();
?>
