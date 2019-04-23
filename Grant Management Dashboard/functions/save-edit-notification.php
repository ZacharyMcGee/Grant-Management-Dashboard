<?php
session_start();
require_once '../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Get POST values
$deadline = $_POST['deadline'];
$email_not = $_POST['email'];

$sql = "UPDATE notifications SET email='$email_not', deadline='$deadline' WHERE id=" . $_SESSION['current_grant'];

if ($con->query($sql) === TRUE) {
    echo "Successfuly edited grant and notification!";
} else {
    echo "Error editing record: " . $con->error;
}

?>
