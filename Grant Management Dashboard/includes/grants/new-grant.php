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

    var deadlineNot=document.getElementById('notification-deadline').value;
    var emailDeadline;
    if(document.getElementById('yeemail').checked){
      emailDeadline=document.getElementById('yeemail').value;
    }
    else{
      emailDeadline=document.getElementById('noemail').value;
    }
    console.log(sessionStorage.getItem("result"));
    $.ajax({
        url: "functions/save-notification.php",
        type: "post",
        data: { 'deadline' : deadlineNot, 'email' : emailDeadline } ,
        success: function (response) {
          console.log(response);
          showAlert("success", response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
      });
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
  var deadlineForm=document.getElementById('notification-deadline').value;

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
  else if (deadlineForm!=="") {
    var pattern=new RegExp('^([0-9]{4}\/((0[1-9]){1}|(1[0-2]){1})\/((0[1-9]){1}|([1-2][0-9]){1}|(3[0-1]){1}))$');
    var patterntest=pattern.test(deadlineForm);
    if(patterntest==false){
      showAlert("error", "Please input deadline as \"YYYY/MM/DD\"!");
      return false;
    }
    var replaceMonth=deadlineForm.split("/");
    if(replaceMonth[1]==='02'){
      var febPattern;
      if(isLeapYear(replaceMonth[0])){
        febPattern=new RegExp('^([0-9]{4}\/(02)\/((0[1-9]){1}|(1[0-9]){1}|(2[0-9]{1})))$');
      }
      else{
        febPattern=new RegExp('^([0-9]{4}\/(02)\/((0[1-9]){1}|(1[0-9]){1}|(2[0-8]{1})))$');
      }
      var febPatternTest=febPattern.test(deadlineForm);
      if(febPatternTest==false){
        showAlert("error", "Incorrect input for February, please input date from 01-28 or 01-29 if leap year!");
        return false;
      }
    }
    if(replaceMonth[1]==='04'||replaceMonth[1]==='06'||replaceMonth[1]==='09'||replaceMonth[1]==='11'){
      var thirtyPattern=new RegExp('^([0-9]{4}\/((04){1}|(06){1}|(09){1}|(11){1})\/((0[1-9]){1}|([1-2][0-9]){1}|(30){1}))$');
      var thirtyPatternTest=thirtyPattern.test(deadlineForm);
      if(thirtyPatternTest==false){
        showAlert("error", "Incorrect input for April, June, September, or November. Please input date from 01-30!");
        return false;
      }
    }
  }
  return true;
}
</script>
</head>
<style>
.input-deadline-notifications {
  float: left;
  height: 70px;
  width: calc(50% - 20px); /* IE 9,10 , Chrome, Firefox */
  width: -webkit-calc(50% - 20px); /*For safari 6.0*/
  padding-top: 10px;
  padding-left: 20px;
}

.input-deadline-notifications p {
  float: left;
  margin: 0px;
  margin-bottom: 5px;
  margin-top: 5px;
  font-size: 12px;
}

.input-email-notifications {
  display: inline-block;
  float: left;
  height: 70px;
  width: calc(50% - 20px); /* IE 9,10 , Chrome, Firefox */
  width: -webkit-calc(50% - 20px); /*For safari 6.0*/
  padding-top: 10px;
  padding-left: 20px;
}

.input-email-notifications p {
  float: left;
  margin: 0px;
  margin-bottom: 5px;
  margin-top: 5px;
  font-size: 12px;
}
</style>
<div class="full-card" style="padding-bottom:20px;">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-file-alt"></i><span class="parent-link">Grant Information</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="card-body">
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
  </div>
</div>

<br>
<div class="full-card" style="padding-bottom:20px;">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-calendar"></i><span class="parent-link">Notifications</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>
<div class="card-body">
  <div class="information-container">
  <div class="input-deadline-notifications">
    <p>Annual Report Deadline</p><span class="small-tip">(optional)</span>
    <div class="input-grant-input-container">
      <i class="fas fa-calendar-times fa-lg fa-fw" aria-hidden="true"></i>
      <input type="text" id="notification-deadline" class="input-text" placeholder="YYYY/MM/DD">
    </div>
  </div>
  <div class="input-email-notifications">
    <p>Email Notifications</p>
    <div class="input-grant-input-container">
      <input type="radio" id="yeemail" name="email" value="1">Yes
      <input type="radio" id="noemail" name="email" value="0" checked>No
    </div>
  </div>
</div>
</div>
</div>

<div class="full-card" style="margin-top:20px; padding-bottom: 20px;">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-table"></i><span class="parent-link">Grant Data</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>
  <div class="data-container">
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
</div>

<div class="button-bar-bottom">
  <button id="cancel-new-grant" class="cancel-button" type="button"><i class="fas fa-ban" style="padding-right:10px;"></i>Cancel</button>
  <button id="save-new-grant" class="save-button" type="button"><i class="far fa-save" style="padding-right:10px;"></i>Save Grant</button>
</div>
