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
  fileInput.files = e.dataTransfer.files;
  readSingleFile(e);
});

$("#save-new-grant").click(function(){
  if(validateNewGrantForm()){
    var grantName = document.getElementById('input-title').value;
    var budgetPurpose = document.getElementById('input-bp').value;
    var dcAwardAmount = document.getElementById('input-dc-award').value;
    var idcAwardAmount = document.getElementById('input-idc-award').value;
    var fundingAgency = document.getElementById('input-agency').value;

    if(idcAwardAmount == ""){
      idcAwardAmount = "n/a";
    }
    
    console.log(sessionStorage.getItem("result"));
    $.ajax({
        url: "functions/save-grant.php",
        type: "post",
        data: { 'jsondata' : sessionStorage.getItem("result"), 'name' : grantName, 'bp' : budgetPurpose, 'dcaward' : dcAwardAmount, 'idcaward' : idcAwardAmount, 'agency' : fundingAgency } ,
        success: function (response) {
          console.log(response);
          showAlert("success", response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }


        });
    //JSON.parse(sessionStorage.getItem("result"));
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
  var dcAwardAmountForm = document.getElementById('input-dc-award');

  if(grantNameForm.value == ""){
    showAlert("error", "You must enter a grant name!");
    return false;
  }
  else if(budgetPurposeForm.value == ""){
    showAlert("error", "You must enter a budget purpose number!");
    return false;
  }
  else if(dcAwardAmountForm.value == ""){
    showAlert("error", "You must enter an award amount!");
    return false;
  }
  else if(isNaN(dcAwardAmountForm.value)){
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
    <div class="information-grant-header">
      <p>Grant Information</p>
    </div>
    <div class="information-container">
    <div class="input-grant-title">
      <p>Grant Name</p><span class="small-asterix">*</span>
      <div class="input-grant-input-container">
        <i class="fas fa-file-signature fa-lg fa-fw" aria-hidden="true"></i>
        <input type="text" id="input-title" class="input-text" maxlength="64">
      </div>
    </div>
    <div class="input-grant-description">
      <p>Budget Purpose #</p><span class="small-asterix">*</span>
      <div class="input-grant-input-container">
        <i class="fas fa-hashtag fa-lg fa-fw" aria-hidden="true"></i>
        <input type="text" id="input-bp" class="input-text" maxlength="64">
      </div>
    </div>
    <div class="input-grant-award">
      <p>DC Award Amount</p><span class="small-asterix">*</span>
      <div class="input-grant-input-container">
        <i class="fas fa-dollar-sign fa-lg fa-fw" aria-hidden="true"></i>
        <input type="text" id="input-dc-award" class="input-text" maxlength="64">
      </div>
    </div>
    <div class="input-grant-award">
      <p>IDC Award Amount</p><span class="small-tip">(optional)</span>
      <div class="input-grant-input-container">
        <i class="fas fa-dollar-sign fa-lg fa-fw" aria-hidden="true"></i>
        <input type="text" id="input-idc-award" class="input-text" maxlength="64">
      </div>
    </div>
    <div class="input-grant-agency">
      <p>Funding Agency</p><span class="small-tip">(optional)</span>
      <div class="input-grant-input-container">
        <i class="fas fa-university fa-lg fa-fw" aria-hidden="true"></i>
        <input type="text" id="input-agency" class="input-text" maxlength="64">
      </div>
    </div>
  </div>
    <div class="information-grant-header">
      <p>Grant Data</p>
    </div>
    <div class="information-container">
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
  </div>
    <div class="button-bar-bottom">
      <button id="cancel-new-grant" class="cancel-button" type="button"><i class="fas fa-ban" style="padding-right:10px;"></i>Cancel</button>
      <button id="save-new-grant" class="save-button" type="button"><i class="far fa-save" style="padding-right:10px;"></i>Save Grant</button>
    </div>
  </div>
</div>
