<?php
require_once '../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$username = $_POST['username'];

$sql="select * from accounts where username='" . $_POST['username'] . "'";
$result = $con->query($sql);


if ($result->num_rows >= 1)
  {
   echo "1";
  }
else
   {
    echo "0";
   }

$con->close();
?>
