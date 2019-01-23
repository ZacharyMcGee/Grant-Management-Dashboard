<?php
session_start();
require_once '../../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$grantid = json_encode($_GET['id']);

$sql = "SELECT name, bp, dc_award, agency, jsondata FROM grants WHERE id=" . $grantid;
$sql2 = "SELECT jsondata, creation_date FROM grant_archive WHERE userid=" . $_SESSION['id'];

global $myJSON;
$result2 = $con->query($sql2);
if ($result2->num_rows > 0) {
    // output data of each row
		while($row = $result2->fetch_assoc()) {
			$myObj = new \stdClass();
			$myObj->x = $row["creation_date"];
			$myObj->y = $row["jsondata"];

			$a = array();
			array_push($a, $myObj);
	}
}
else
{
    echo "0 results";
}

$myJSON = json_encode($a);

$result = $con->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    $name = $row["name"];
		echo "<canvas id='timeChart'></canvas><script>linearTimeChart(" . $myJSON . ");</script>";
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

		<?php ?>
  </div>
</div>
