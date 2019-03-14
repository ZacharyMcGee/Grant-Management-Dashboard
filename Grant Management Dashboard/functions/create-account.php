<?php
require_once '../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Get POST values
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO accounts (username, password, email)
VALUES ('$username', '$hashed_password', '$email')";

if ($con->query($sql) === TRUE) {
    echo "Successfuly created account!";
} else {
    echo "Error creating account: " . $con->error;
}

$con->close();
?>
