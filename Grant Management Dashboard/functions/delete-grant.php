<?php
session_start();
require_once '../config.php';

// Connect to DB
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$grantid = json_encode($_GET['id']);

$sql = "DELETE FROM grants WHERE id=" . $grantid;

if ($con->query($sql) === TRUE) {
    echo "Successfuly deleted grant!";
} else {
    echo "Error updating record: " . $con->error;
}

?>
