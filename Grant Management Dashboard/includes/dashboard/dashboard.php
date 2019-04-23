<?php
if(!isset($_SESSION)) {
	session_start();
	require_once '../../config.php';
}

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, dc_award, idc_award, agency, jsondata, active, creation_date FROM grants WHERE userid=" . $_SESSION['id'];
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
		$totalActiveGrantDC = 0;
		$totalActiveGrantIDC = 0;
    $numOfActiveGrants = 0;
    $numOfInactiveGrants = 0;
		$grantList = "<table><tr><th>Status</th><th>Grant Name</th><th>Budget Purpose #</th><th>Direct Cost Award</th><th>Indirect Cost Award</th><th>Funding Agency</th><th>Creation Date</th></tr>";

    while($row = $result->fetch_assoc()) {
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

			$activeImage;
			// Here we count the number of active and inactive grants
			// And we also check if the current grant should have an active
			// icon or inactive icon for the table
      if($row["active"] == 1){
        $numOfActiveGrants++;
				$activeImage = "<img src='images/active-icon.png'>";
				$totalActiveGrantDC = $totalActiveGrantDC + $row["dc_award"];
				if(is_numeric($row["idc_award"])){
					$totalActiveGrantIDC = $totalActiveGrantIDC + $row["idc_award"];
				}
      }
      else
      {
        $numOfInactiveGrants++;
				$activeImage = "<img src='images/inactive-icon.png'>";
      }

			$formattedTotalIDCAward = '$' . number_format($totalActiveGrantIDC, 2);
			$formattedTotalDCAward = '$' . number_format($totalActiveGrantDC, 2);
			$formattedDCAward = '$' . number_format($row["dc_award"], 2);

			if(is_numeric($row["idc_award"])){
				 $formattedIDCAward = '$' . number_format($row["idc_award"], 2);
			}
			else
			{
				$formattedIDCAward = $row["idc_award"];
			}

			$grantList .= "<tr onClick='openGrant(" . $row["id"] . ")'><td style='padding-left: 30px;'>" . $activeImage . "</td><td>" . $row["name"] . "</td><td>" . $row["bp"] . "</td><td>" . $formattedDCAward . "</td><td>" . $formattedIDCAward . "</td><td>" . $row["agency"] . "</td><td>" . $timeSinceUpdate . "</td></tr>";
    }
		$grantList .= "</table>";
  }
else
{
    echo "0 results";
}

$con->close();
?>

<div class="fourth-card">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-file-invoice-dollar" style="color:#4bc0c0;"></i><span class="parent-link">Total Direct Cost Awards</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

	<div class="total-grants-card">
		<div class="view-all"><i class="fas fa-info-circle"></i> Total DC Awards for <a href="">Active Grants</a></div>
		 <div class="current-active-grants"><?php echo $formattedTotalDCAward ?></div>
		</div>
</div>

<div class="fourth-card">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-file-invoice-dollar" style="color:#ff6384;"></i><span class="parent-link">Total Indirect Cost Awards</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="total-grants-card">
		<div class="view-all"><i class="fas fa-info-circle"></i> Total IDC Awards for <a href="">Active Grants</a></div>
		 <div class="current-active-grants"><?php echo $formattedTotalIDCAward ?></div>
  </div>
</div>

<div class="fourth-card">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-play-circle" style="color:#93cca3;"></i><span class="parent-link">Total Active Grants</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="total-grants-card">
		<div class="view-all"><i class="fas fa-info-circle"></i> Total Grants <a href="">Currently Active</a></div>
     <div class="current-active-grants"><?php echo $numOfActiveGrants ?> / <?php echo ($numOfActiveGrants + $numOfInactiveGrants) ?></div>
  </div>
</div>

<div class="fourth-card" style="margin-right: 0px;">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-stop-circle" style="color:#ffbd94;"></i><span class="parent-link">Total Inactive Grants</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="total-grants-card">
		<div class="view-all"><i class="fas fa-info-circle"></i> Total Grants <a href="">Currently Inactive</a></div>
		 <div class="current-active-grants"><?php echo $numOfInactiveGrants ?> / <?php echo ($numOfActiveGrants + $numOfInactiveGrants) ?></div>
		</div>
  </div>

<div class="full-card" style="margin-top: 135px;">
	<div class="card-title">
		<div class="card-title-text">
			<i class="fas fa-list" style="color:#7d7d7d;"></i><span class="parent-link">All Grants</span>
		</div>
	</div>
	<div class="all-grants-table">
		<?php echo $grantList ?>
	</div>
</div>

<div class="full-card" style="margin-top: 20px;">
	<div class="card-title" style="border-bottom: none">
		<div class="card-title-text">
			<i class="fas fa-calendar-alt" style="color:#7d7d7d;"></i><span class="parent-link">Calendar</span>
		</div>
	</div>
	<?php
	if(file_exists('includes/tasks/calendar.php')) {
		include_once('includes/tasks/calendar.php');
	}
	else
	{
		include_once('../../includes/tasks/calendar.php');
		echo getcwd();
	}
	?>
</div>
