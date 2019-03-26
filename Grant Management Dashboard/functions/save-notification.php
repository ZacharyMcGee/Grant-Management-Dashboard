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
$deadline = $_POST['deadline'];
$timedead = $_POST['times'];
$repeat_not = $_POST['repeat'];
$email_not = $_POST['email'];

$sql = "INSERT INTO `notifications` (`id`, `email`, `repeat`, `time`, `deadline`, `jsondata`, `userid`)
VALUES (NULL, '$email_not', '$repeat_not', '$timedead', '$deadline', NULL, '$userId')";

if ($con->query($sql) === TRUE) {
    echo "Successfuly created grant and notification!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
