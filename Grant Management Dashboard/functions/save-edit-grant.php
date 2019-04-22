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
$bp = $_POST['bp'];
$dc_award = $_POST['dcaward'];
$idc_award = $_POST['idcaward'];
$agency = $_POST['agency'];

$sql_updatecurrentdata = "UPDATE grants SET name='$name', bp='$bp', dc_award='$dc_award', idc_award='$idc_award', agency='$agency', last_update=now() WHERE id=" . $_SESSION['current_grant'];

if ($con->query($sql_updatecurrentdata) === TRUE)
{
    echo "Successfuly updated grant!";
}
else
{
    echo "Error updating record: " . $con->error;
}

?>
