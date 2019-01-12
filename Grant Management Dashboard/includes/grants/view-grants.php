<?php
session_start();
require_once '../../config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, dc_award, agency, jsondata, creation_date FROM grants WHERE userid=" . $_SESSION['id'];
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $i = 0;
    while($row = $result->fetch_assoc()) {
			  // Show when the last we updated the data
				// We show the biggest value, e.g. if it's a day then we will hide hours and seconds
			  $date = new \DateTime();
				$date->setTimestamp(strtotime($row['creation_date']));
				$interval = $date->diff(new \DateTime('now'));
				$timeInSeconds = $interval->format('%s');
				$timeInMinutes = $interval->format('%i');
				$timeInHours = $interval->format('%h');
				$timeInDays = $interval->format('%d');
				$timeInMonths = $interval->format('%m');
				$timeInYears = $interval->format('%y');

        if($timeInYears <= 0) {
					if($timeInMonths <= 0) {
						if($timeInDays <= 0) {
							if($timeInHours <= 0) {
								if($timeInMinutes <= 0) {
									if($timeInSeconds <= 0) {
                    $timeSinceUpdate = $interval->format('0 seconds ago');
									}
									else
									{
										$timeSinceUpdate = $interval->format('%s seconds ago');
									}
								}
								else
								{
									$timeSinceUpdate = $interval->format('%m minutes ago');
								}
							}
							else
							{
								$timeSinceUpdate = $interval->format('%h hours ago');
							}
						}
						else
						{
						$timeSinceUpdate = $interval->format('%d days ago');
					  }
					}
					else
					{
						$timeSinceUpdate = $interval->format('%m months ago');
					}
				}
				else
				{
					$timeSinceUpdate = $interval->format('%y years ago');
				}

		    $formattedAward = '$' . number_format($row["dc_award"], 2);

        echo "<a href='#' onClick='openGrant(" . $row["id"] . ")'><div class='full-card-left-border-active'><div class='view-grants-chart'><canvas id='chart" . $i . "'></canvas></div><div class='view-grants-info'><span class='view-grants-title'>" . $row["name"] . " </span><div class='view-grants-bp'> #" . $row["bp"] . "</div><br><span class='view-grants-update'> Updated " . $timeSinceUpdate . "</span><br><span class='view-grants-award'>DC Award: " . $formattedAward . "</span></div><div class='view-grants-buttons'><button class='button'>Manage</button><button class='button'>Report</button><button class='button'>Delete</button></div></div></a><script>moneyLeftPieChart('chart" . $i . "','" . $row["dc_award"] . "','" . $row["jsondata"] . "');</script>";
        $i++;
    }
}
else
{
    echo "0 results";
}

$con->close();
?>
