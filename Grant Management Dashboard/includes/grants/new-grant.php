<head>
<script type="text/javascript">
var dragarea = document.getElementById('drag-and-drop');
var fileInput = document.getElementById('file-upload');

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
  dragarea.classList.add('dropped');
  fileInput.files = e.dataTransfer.files;
  readSingleFile(e);
});

$("#save-new-grant").click(function(){
  if(validateNewGrantForm()){
    showAlert("success", "Grant saved successfully!");
  }
});

$("#cancel-new-grant").click(function(){
  $.ajax({url: "includes/dashboard/dashboard.php", success: function(result){
      $("#content").html(result);
      $("#breadcrumbs").html("<p>Home / Dashboard</p>");
  }});
});

function validateNewGrantForm(){
  var grantNameForm = document.getElementById('input-title');
  var budgetPurposeForm = document.getElementById('input-bp');
  var awardAmountForm = document.getElementById('input-award');

  if(grantNameForm.value == ""){
    showAlert("error", "You must enter a grant name!");
    return false;
  }
  else if(budgetPurposeForm.value == ""){
    showAlert("error", "You must enter a budget purpose number!");
    return false;
  }
  else if(awardAmountForm.value == ""){
    showAlert("error", "You must enter an award amount!");
    return false;
  }
  else if(isNaN(awardAmountForm.value)){
    showAlert("error", "Award must be a valid dollar amount!");
    return false;
  }
  return true;
}
</script>
</head>
<div class="full-card">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-plus-circle"></i><span class="parent-link">New Grant</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="card-body">
    <div class="input-grant-title">
      <p>Grant Name</p><span class="small-asterix">*</span>
      <input type="text" id="input-title" class="input-text">
    </div>
    <div class="input-grant-description">
      <p>Budget Purpose #</p><span class="small-asterix">*</span>
      <input type="text" id="input-bp" class="input-text">
    </div>
    <div class="input-grant-award">
      <p>Award Amount</p><span class="small-asterix">*</span>
      <input type="text" id="input-award" class="input-text">
    </div>
    <div class="input-grant-agency">
      <p>Funding Agency</p>
      <input type="text" id="input-agency" class="input-text">
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
    <div class="button-bar-bottom">
      <button id="cancel-new-grant" class="cancel-button" type="button"><i class="fas fa-ban" style="padding-right:10px;"></i>Cancel</button>
      <button id="save-new-grant" class="save-button" type="button"><i class="far fa-save" style="padding-right:10px;"></i>Save Grant</button>
    </div>
  </div>
</div>
