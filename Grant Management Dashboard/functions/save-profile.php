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
$name = $_POST['name'];
$username = $_POST['un'];
$email = $_POST['email'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if($password != ""){
	$sql = "UPDATE accounts
	SET name = '$name' , username = '$username', email = '$email', password = '$hashed_password'
	WHERE id =" . $userId;
}else{
	$sql = "UPDATE accounts
	SET name = '$name' , username = '$username', email = '$email'
	WHERE id =" . $userId;
}

if ($con->query($sql) === TRUE) {
    echo "Successfuly updated profile!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
