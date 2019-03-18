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

$id = $_POST['id'];

if($id > 0){
    
    $check = mysqli_query($con, "SELECT * FROM posts WHERE id=" . $id);
    $totalRows = mysqli_num_rows($check);
    
    if($totalRows > 0){
        $query = "DELETE FROM grants WHERE id=" . $id;
        mysqli_query($con, $query);
        echo 1;
        exit;
    }
    
}





?>