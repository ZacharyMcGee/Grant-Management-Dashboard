<?php
session_start();
require_once '../../config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, award, agency FROM grants WHERE userid=" . $_SESSION['id'];
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='full-card'><div class='card-title'><div class='card-title-text'><a href='url'><i class='far fa-chart-bar'></i><span class='parent-link'>" . $row["name"] . "</a></span></div></div><div class='body'><p>hey</p></div></div>";
    }
}
else
{
    echo "0 results";
}

$con->close();
?>
