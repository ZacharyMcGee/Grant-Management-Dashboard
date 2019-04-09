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
$id = $_POST['id'];

$sql = "DELETE FROM grants WHERE id=" . $id;

if ($con->query($sql) === TRUE) {
    echo "Successfuly created grant!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
