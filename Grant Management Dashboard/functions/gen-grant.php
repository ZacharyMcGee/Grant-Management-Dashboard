<?php
session_start();
require_once '../config.php';

// Connect to DB
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Get POST values

$dc_award = $_POST['dcaward'];

$con->close();

?>