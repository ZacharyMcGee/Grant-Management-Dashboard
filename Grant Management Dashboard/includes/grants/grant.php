<?php
session_start();
require_once '../../config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$grantid = json_encode($_GET['id']);

$sql = "SELECT name, bp, award, agency, jsondata FROM grants WHERE id=" . $grantid;
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    $name = $row["name"];
}
else
{
    echo "0 results";
}

$con->close();
?>

<div class='full-card'>
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'><?php echo $name ?></span></div>
  </div>
  <div class='body'>
    <p>hey</p>
  </div>
</div>
