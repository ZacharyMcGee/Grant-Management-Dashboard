<?php
session_start();
require_once '../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Get current user
$userId = $_SESSION['id'];

// Get POST values
$jsondata = json_encode($_POST['jsondata']);
$name = $_POST['name'];
$bp = $_POST['bp'];
$dc_award = $_POST['dcaward'];
$idc_award = $_POST['idcaward'];
$agency = $_POST['agency'];

$sql = "INSERT INTO grants (userid, name, bp, dc_award, idc_award, agency, jsondata)
VALUES ('$userId', '$name', '$bp', '$dc_award', '$idc_award', '$agency', '$jsondata')";

if ($con->query($sql) === TRUE) {
    echo "Successfuly created grant!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
