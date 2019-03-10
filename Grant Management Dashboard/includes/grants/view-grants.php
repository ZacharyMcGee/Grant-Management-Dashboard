<?php
session_start();
require_once '../../config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, dc_award, idc_award, agency, jsondata, creation_date FROM grants WHERE userid=" . $_SESSION['id'];
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

		    $formattedDCAward = '$' . number_format($row["dc_award"], 2);

				if(is_numeric($row["idc_award"])){
           $formattedIDCAward = '$' . number_format($row["idc_award"], 2);
			  }
				else
				{
					$formattedIDCAward = $row["idc_award"];
				}

				if($i > 1){
					echo "<div class='full-card-left-border-active' style='margin-top: 20px;'><div class='view-grants-chart'><canvas id='chart" . $i . "'></canvas></div><div class='view-grants-info'><div class='view-grants-top'><span class='view-grants-title'>" . $row["name"] . " </span><div class='view-grants-bp'> #" . $row["bp"] . "</div></div><br><span class='view-grants-update'> Updated " . $timeSinceUpdate . "</span><br><span class='view-grants-award-title'>Awards</span><br><span class='view-grants-award'>Direct Cost: " . $formattedDCAward . "</span><span class='view-grants-award'>Indirect Cost: " . $formattedIDCAward . "</span></div><div class='view-grants-buttons'><a href='#' onClick='openGrant(" . $row["id"] . ")'><button class='button'>View</button></a><button class='Edit'>Report</button><button class='button'>Delete</button></div></div><script>moneyLeftPieChart('chart" . $i . "','" . $row["dc_award"] . "','" . $row["jsondata"] . "');</script>";
					$i++;
        }
				else
				{
					echo "<div class='full-card-left-border-active'><div class='view-grants-chart'><canvas id='chart" . $i . "'></canvas></div><div class='view-grants-info'><div class='view-grants-top'><span class='view-grants-title'>" . $row["name"] . " </span><div class='view-grants-bp'> #" . $row["bp"] . "</div></div><br><span class='view-grants-update'> Updated " . $timeSinceUpdate . "</span><br><span class='view-grants-award-title'>Awards</span><br><span class='view-grants-award'>Direct Cost: " . $formattedDCAward . "</span><span class='view-grants-award'>Indirect Cost: " . $formattedIDCAward . "</span></div><div class='view-grants-buttons'><a href='#' onClick='openGrant(" . $row["id"] . ")'><button class='button'>View</button></a><button class='button'>Edit</button><button class='button'>Delete</button></div></div><script>moneyLeftPieChart('chart" . $i . "','" . $row["dc_award"] . "','" . $row["jsondata"] . "');</script>";
        	$i++;
				}
    }
}
else
{
    echo "0 results";
}

$con->close();
?>
