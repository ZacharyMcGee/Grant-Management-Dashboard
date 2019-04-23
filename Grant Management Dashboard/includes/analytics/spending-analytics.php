<?php
session_start();
require_once '../../config.php';


$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT id, name, bp, dc_award, idc_award, agency, jsondata, creation_date FROM grants WHERE userid=" . $_SESSION['id'];
$result = $con->query($sql);
$i = "";
$j = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $resultjson = $row["jsondata"];
      $resultjson = substr($resultjson, 1, -1);
      $i = $i . $resultjson;
    }
    $spendingDayAnalyizer = "<canvas id='spendingDayAnalyizer'></canvas><script>spendingDayAnalyizer('spendingDayAnalyizer','" . $i . "');</script>";
    $spendingMonthAnalyizer = "<canvas id='spendingMonthAnalyizer'></canvas><script>spendingMonthAnalyizer('spendingMonthAnalyizer','" . $i . "');</script>";
    $spendingBusinessAnalyizer = "<canvas id='spendingBusinessAnalyizer'></canvas><script>spendingBusinessAnalyizer('spendingBusinessAnalyizer','" . $i . "');</script>";
    $spendingExpenseAnalyizer = "<script>spendingExpenseAnalyizer('spendingExpenseAnalyizer','" . $i . "');</script>";
  }
else
{
  echo "0 results";
}
$con->close();
?>

<div class='sixty-card' style="margin-top:0px; padding-bottom: 20px;">
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'>Monthly Spending Trends</span></div>
  </div>
  <div class='body'>
    <div class="day-spending-analysis">
      <?php echo $spendingMonthAnalyizer ?>
    </div>
	</div>
</div>

<div class='forty-card' style="margin-top:0px; padding-bottom: 20px;">
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'>Day of the Week Spending Trends</span></div>
  </div>
  <div class='body'>
    <div class="day-spending-analysis">
      <?php echo $spendingDayAnalyizer ?>
    </div>
	</div>
</div>

<div class='sixty-card' style="margin-top:20px; padding-bottom: 0px;">
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'>Largest Expense by Supplier</span></div>
  </div>
  <div class='body'>
    <div class="day-spending-analysis" style="margin-top:0px; margin-bottom: -3px;">
      <?php echo $spendingExpenseAnalyizer ?>
      <div class="topExpenses" id="topExpenses">
      </div>
    </div>
	</div>
</div>

<div class='forty-card' style="margin-top:20px; padding-bottom: 20px;">
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'>Most Transactions by Supplier</span></div>
  </div>
  <div class='body'>
    <div class="business-spending-analysis">
      <?php echo $spendingBusinessAnalyizer ?>
      <div id="htmllegend" style="margin-top: 20px">
      </div>
    </div>
	</div>
</div>
