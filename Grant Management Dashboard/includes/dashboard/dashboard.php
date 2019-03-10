<?php

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, dc_award, idc_award, agency, jsondata, active, creation_date FROM grants WHERE userid=" . $_SESSION['id'];
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $numOfActiveGrants = 0;
    $numOfInactiveGrants = 0;

    while($row = $result->fetch_assoc()) {
      if($row["active"] == 1){
        $numOfActiveGrants++;
      }
      else
      {
        $numOfInactiveGrants++;
      }

    }
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

<div class="fourth-card">
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

<div class="fourth-card">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-exclamation-circle" style="color:#f37066;"></i><span class="parent-link">Grants Needing Update</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="total-grants-card">

  </div>
</div>

<div class="fourth-card" style="margin-right: 0px;">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-plus-circle" style="color:#ffbd94;"></i><span class="parent-link">Total Inactive Grants</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="total-grants-card">

  </div>
</div>

<div class="full-card" style="margin-top: 135px;">
	<div class="card-title">
		<div class="card-title-text">
			<i class="fas fa-list" style="color:#7d7d7d;"></i><span class="parent-link">All Grants</span>
		</div>
	</div>
</div>
