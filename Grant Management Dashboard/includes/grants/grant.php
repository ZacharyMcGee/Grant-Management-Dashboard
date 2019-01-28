<?php
session_start();
require_once '../../config.php';

$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$grantid = json_encode($_GET['id']);
$_SESSION["current_grant"] = $grantid;

$sql = "SELECT name, bp, dc_award, agency, jsondata, creation_date FROM grants WHERE id=" . $grantid;
$sql2 = "SELECT jsondata, creation_date FROM grant_archive WHERE grantid=" . $grantid;

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


$result = $con->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
		$myObj2 = new \stdClass();
		$myObj2->x = $row["creation_date"];
		$myObj2->y = $row["jsondata"];

		array_push($a, $myObj2);
    $name = $row["name"];
		$myJSON = json_encode($a);
		$timeChart = "<canvas id='timeChart'></canvas><script>linearTimeChart(" . $myJSON . ");</script>";
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
</script>
</head>
<div class='full-card'>
  <div class='card-title'>
    <div class='card-title-text'><span class='parent-link'><?php echo $name ?></span></div>
  </div>
  <div class='body'>
		<div class="timechart">
			<?php echo $timeChart ?>
		</div>
		<div class="past-data-table">

		</div>

		<div class="drag-and-drop-description">
			<p id="upload-excel-p">Upload Excel Data</p><span id="small-hint" class="small-hint">(.xlsx format)</span>
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
