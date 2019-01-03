<?php
session_start();
require_once '../../config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, award, agency, jsondata FROM grants WHERE userid=" . $_SESSION['id'];
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $i = 0;
    while($row = $result->fetch_assoc()) {
        echo "<a href='#' onClick='openGrant(" . $row["id"] . ")'><div class='full-card-left-border-active'><div class='body'><div class='view-grants-chart'><canvas id='chart" . $i . "'></canvas></div><div class='view-grants-info'><span class='view-grants-title'>" . $row["name"] . "</span></div></div></div></a><script>moneyLeftPieChart('chart" . $i . "','" . $row["award"] . "','" . $row["jsondata"] . "');</script>";
        $i++;
    }
}
else
{
    echo "0 results";
}

$con->close();
?>
