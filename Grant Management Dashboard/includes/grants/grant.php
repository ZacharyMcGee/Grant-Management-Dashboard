<?php
session_start();
require_once '../../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$grantid = json_encode($_GET['id']);
$_SESSION["current_grant"] = $grantid;

$sql = "SELECT name, bp, dc_award, idc_award, agency, jsondata, creation_date FROM grants WHERE id=" . $grantid;
$sql2 = "SELECT jsondata, creation_date FROM grant_archive WHERE grantid=" . $grantid;

global $myJSON;

$result2 = $con->query($sql2);
if ($result2->num_rows > 0) {
    // output data of each row
		$i = 0;
		$a = array();
		while($row = $result2->fetch_assoc()) {
			$i++;
			$myObj = new \stdClass();
			$myObj->x = $row["creation_date"];
			$myObj->y = $row["jsondata"];

			array_push($a, $myObj);

	}
}
else
{
		$a = array(); // If we only have 1 data set
}


$result = $con->query($sql);


if ($result->num_rows > 0) {
    // output data of each row

    $row = $result->fetch_assoc();
		$json = $row["jsondata"];
		$myObj2 = new \stdClass();
		$myObj2->x = $row["creation_date"];
		$myObj2->y = $json;

		array_push($a, $myObj2);
    $name = $row["name"];
		$myJSON = json_encode($a);

		if(is_numeric($row["dc_award"])){
			 $formattedDCAward = '$' . number_format($row["dc_award"], 2);
		}
		else
		{
			$formattedDCAward = $row["dc_award"];
		}

		if(is_numeric($row["idc_award"])){
			 $formattedIDCAward = '$' . number_format($row["idc_award"], 2);
		}
		else
		{
			$formattedIDCAward = $row["idc_award"];
		}
		echo "<script>setBreadcrumb('" . "<a href=\'javascript:openViewGrants()\'>Grants</a> / " . $row["name"] . "')</script>";

		$timeChart = "<canvas id='timeChart'></canvas><script>linearTimeChart('" . $json . "','" . $row["dc_award"] . "','" . $row["idc_award"] . "');</script>";
		$dcRemaining = "<canvas id='dcLeftPieChart'></canvas><script>dcMoneyLeftPieChart('dcLeftPieChart','" . $row["dc_award"] . "','" . $json . "');</script>";
		$dcSpendingBreakdown = "<div class='dc-breakdown'>Award: <span class='awarded'>" . $formattedDCAward . "</span>\nSpent: <span class='spent' id='dc-spent'></span><hr class='custom-hr'><span class='remaining' id='dc-remaining'></span></div><script>setDCBreakdown('" . $json . "','" . $row["dc_award"] . "');</script>";

		$idcRemaining = "<canvas id='idcLeftPieChart'></canvas><script>idcMoneyLeftPieChart('idcLeftPieChart','" . $row["idc_award"] . "','" . $json . "');</script>";
		$idcSpendingBreakdown = "<div class='idc-breakdown'>Award: <span class='awarded'>" . $formattedIDCAward . "</span>\nSpent: <span class='spent' id='idc-spent'></span><hr class='custom-hr'><span class='remaining' id='idc-remaining'></span></div><script>setIDCBreakdown('" . $json . "','" . $row["idc_award"] . "');</script>";

		$categoryBreakdown = "<canvas id='categoryBreakdownChart'></canvas><script>categoryBreakdownChart('categoryBreakdownChart','" . $json . "');</script>";
		$categoryBreakdownLabels = "<div class='category-breakdown'><span class='salaries'>Salaries: </span><span class='spent' id='salaries'></span><br><span class='fringe'>Prof. Fringe: </span><span class='spent' id='fringe'></span><br><span class='persfringe'>Pers. Fringe: </span><span class='spent' id='persfringe'></span><br><span class='travel'>Travel: </span><span class='spent' id='travel'></span><br>\n<span class='equipment'>Equipment: </span><span class='spent' id='equipment'></span><br><span class='commodity'>Commodity: </span><span class='spent' id='commodities'></span></div><script>setCategoryBreakdown('" . $json . "','" . $row["idc_award"] . "');</script>";

		$report = "<button id='generate-grant-report' class='gen-button' onClick=generateGrantReport('" . $row["dc_award"] . "','" . $row["idc_award"] . "','" . $row["bp"] . "');> Generate Report</button>";
}
else
{
    echo "0 results";
}

$con->close();
?>
<head>
<script type="text/javascript">
var dragarea = document.getElementById('drag-and-drop');
var fileInput = document.getElementById('file-upload');
document.getElementById('file-upload').addEventListener('change', readSingleFile, false);

dragarea.addEventListener('dragover', (e) => {
  e.preventDefault();
  dragarea.classList.add('dragging');
});

dragarea.addEventListener('dragleave', () => {
  dragarea.classList.remove('dragging');
});

dragarea.addEventListener('drop', (e) => {
  e.preventDefault();
  dragarea.classList.remove('dragging');
  fileInput.files = e.dataTransfer.files;
  readSingleFile(e);
});

$("#update-grant-data").click(function(){
    console.log(sessionStorage.getItem("result"));
		$.ajax({
        url: "functions/update-grant.php",
        type: "post",
        data: { 'jsondata' : sessionStorage.getItem("result") } ,
        success: function (response) {
          console.log(response);
          showAlert("success", response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
        });
});



function generateGrantReport(dc, idc, bp){
		var dcspent = document.getElementById("dc-spent").innerHTML;
		var idcspent = document.getElementById("idc-spent").innerHTML;

		 var dcremaining = document.getElementById("dc-remaining").innerHTML;
		 var idcremaining = document.getElementById("idc-remaining").innerHTML;

		 dcremaining = dcremaining.replace('= ', '');
		 idcremaining = idcremaining.replace('= ', '');

		 var doc = new jsPDF({orientation: 'landscape'});

		 var newdc = moneyFormat(dc);
		 var newidc = moneyFormat(idc);
		 var newbp = bp.toString();

		 var title = "Report for Grant #" + newbp;

		 var canv = document.getElementById('timeChart');
		 var img = canv.toDataURL("image/png");

		 doc.setFontSize(24);
		 doc.text(title, '10', '15');
		 doc.line(10, 20, 287, 20);
		 //doc.text(newdc, '10', '20');
		 doc.setFontSize(18);
		 doc.text("Direct Cost", 10, 35);
		 doc.setFontSize(12);
		 var tempdc = 'Direct Cost Awarded: ' + newdc;
		 doc.text(tempdc, 10, 40);
		 var tempspdc = 'Direct Cost Spent: ' + dcspent;
		 doc.text(tempspdc, 10, 45);
		 var tempdcr = 'Direct Cost Remaining: ' + dcremaining;
		 doc.text(tempdcr, 10, 50);

		 doc.setFontSize(18);
		 doc.text("Indirect Cost", 10, 65);
		 doc.setFontSize(12);
		 var tempidc = 'Indirect Cost Awarded: ' + newidc;
		 doc.text(tempidc, 10, 70);
		 var tempsidc = 'Indirect Cost Spent: ' + idcspent;
		 doc.text(tempsidc, 10, 75);
		 var tempsidcr = 'Indirect Cost Remaining: ' + idcremaining;
		 doc.text(tempsidcr, 10, 80);

		 doc.addImage(img, "PNG", 48.5, 90, 200, 110);

		 doc.save('Report.pdf');

}

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.1.1/jspdf.plugin.autotable.js"></script>

</head>
<div class="fourth-card-tall">
	<div class='card-title'>
		<div class='card-title-text'><span class='parent-link'>Remaining Direct Cost</span></div>
	</div>
	<div class="remaining-awards">
		<div class="dc-award-chart">
			<?php echo $dcRemaining ?>
		</div>
		<div class="spending-breakdown">

            <?php echo $dcSpendingBreakdown ?>
		</div>
	</div>
</div>

<div class="fourth-card-tall">
	<div class='card-title'>
		<div class='card-title-text'><span class='parent-link'>Remaining Indirect Cost</span></div>
	</div>
	<div class="remaining-awards">
		<div class="dc-award-chart">
			<?php echo $idcRemaining ?>
		</div>
		<div class="spending-breakdown">
			<?php echo $idcSpendingBreakdown ?>
		</div>
	</div>
</div>

<div class="fourth-card-tall">
	<div class='card-title'>
		<div class='card-title-text'><span class='parent-link'>Direct Cost Breakdown</span></div>
	</div>
	<div class="remaining-awards">
		<div class="category-breakdown-chart">
			<?php echo $categoryBreakdown ?>
		</div>
		<div class="category-breakdown">
			<?php echo $categoryBreakdownLabels ?>
		</div>
	</div>
</div>

<div class="fourth-card-tall">
	<div class='card-title'>
		<div class='card-title-text'><span class='parent-link'>Generate Report</span></div>
	</div>
	<div class="remaining-awards">
       <?php echo $report ?>

	</div>
</div>
<div class='full-card' style="margin-top:160px; padding-bottom: 20px;">
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'>Spending Timeline</span></div>
  </div>
  <div class='body'>
			<div class="timechart">
                <?php echo "<canvas id='timeChart'></canvas><script>linearTimeChart('" . $json . "','" . $row["dc_award"] . "','" . $row["idc_award"] . "');</script>" ?>
		</div>
	</div>
</div>

<div class='full-card' style='margin-top: 20px; padding-bottom: 20px;'>
	<div class='card-title'>
		<div class='card-title-text'><span class='parent-link'>Update Grant Data</span></div>
	</div>
	<div class="update-grant-data">
<div class="drag-and-drop-description">
	<p id="upload-excel-p">Update Grant Data</p><span id="small-hint" class="small-hint">(.xlsx format)</span>
</div>
<div id="drag-and-drop" class="drag-and-drop">
	<div class="drag-and-drop-text">
		<p>Drag and Drop File Here</p>
	</div>
	<div class="drag-and-drop-text-or">
		<p>or</p>
	</div>
	<label for="file-upload" class="custom-file-upload">
			Select File
	</label>
	<input id="file-upload" type="file"/>
</div>
<button id="update-grant-data" class="save-button" type="button"><i class="far fa-save" style="padding-right:10px;"></i>Update Grant</button>
</div>
</div>
