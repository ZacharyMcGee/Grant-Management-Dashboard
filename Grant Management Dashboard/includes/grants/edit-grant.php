<?php
session_start();
require_once '../../config.php';

  $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  if ( mysqli_connect_errno() ) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }

  $grantid = json_encode($_GET['id']);

  $sql="SELECT name,bp,dc_award,idc_award,agency FROM `grants` WHERE `id` =" . $grantid;
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $name=$row["name"];
        $budget=$row["bp"];
        $dc=$row["dc_award"];
        $idc=$row["idc_award"];
        $agency=$row["agency"];
      }
  }
  $sql="SELECT email,deadline FROM `notifications` WHERE `id` = ". $grantid;
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $email=$row["email"];
        $deadline=$row["deadline"];
      }
  }
  $con->close();
?>

<body>
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
          <input type="text" id="input-title" class="input-text" maxlength="64" value="<?php echo $name ?>">
        </div>
      </div>
      <div class="input-grant-description">
        <p>Budget Purpose #</p><span class="small-asterix">*</span>
        <div class="input-grant-input-container">
          <i class="fas fa-hashtag fa-lg fa-fw" aria-hidden="true"></i>
          <input type="text" id="input-bp" class="input-text" maxlength="64" value="<?php echo $budget ?>">
        </div>
      </div>
      <div class="input-grant-award">
        <p>DC Award Amount</p><span class="small-asterix">*</span>
        <div class="input-grant-input-container">
          <i class="fas fa-dollar-sign fa-lg fa-fw" aria-hidden="true"></i>
          <input type="text" id="input-dc-award" class="input-text" maxlength="64" value="<?php echo $dc ?>">
        </div>
      </div>
      <div class="input-grant-award">
        <p>IDC Award Amount</p><span class="small-tip">(optional)</span>
        <div class="input-grant-input-container">
          <i class="fas fa-dollar-sign fa-lg fa-fw" aria-hidden="true"></i>
          <input type="text" id="input-idc-award" class="input-text" maxlength="64" value="<?php echo $idc ?>">
        </div>
      </div>
      <div class="input-grant-agency">
        <p>Funding Agency</p><span class="small-tip">(optional)</span>
        <div class="input-grant-input-container">
          <i class="fas fa-university fa-lg fa-fw" aria-hidden="true"></i>
          <input type="text" id="input-agency" class="input-text" maxlength="64" value="<?php echo $agency ?>">
        </div>
      </div>
    </div>
    </div>
  </div>

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

  <div class="button-bar-bottom">
    <button id="cancel-editing" class="cancel-button" type="button"><i class="fas fa-ban" style="padding-right:10px;"></i>Cancel</button>
    <button id="save-edited-grant" class="save-button" type="button"><i class="far fa-save" style="padding-right:10px;"></i>Save Edits</button>
  </div>
</body>

<script>
  $("#save-edited-grant").click(function(){
      console.log(sessionStorage.getItem("result"));
      $.ajax({
          url: "functions/save-edit-grant.php",
          type: "post",
          data: { 'name' : document.getElementById("input-title").value, 'bp' : document.getElementById("input-bp").value, 'dcaward' : document.getElementById("input-dc-award").value, 'idcaward' : document.getElementById("input-idc-award").value, 'agency' : document.getElementById("input-agency").value } ,
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
          url: "functions/save-edit-notification.php",
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
  });

  $("#cancel-editing").click(function(){
    $.ajax({url: "includes/grants/view-grants.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p>Home / View Grants</p>");
    }});
  });

  function validateNewGrantForm(){
    var grantNameForm = document.getElementById('input-title');
    var budgetPurposeForm = document.getElementById('input-bp');
    var dcAwardAmountForm = document.getElementById('input-dc-award');
    var deadlineForm=document.getElementById('notification-deadline').value;

    if(grantNameForm.value == ""){
      showAlert("error", "There must be a grant name!");
      return false;
    }
    else if(budgetPurposeForm.value == ""){
      showAlert("error", "There must be a budget purpose number!");
      return false;
    }
    else if(dcAwardAmountForm.value == ""){
      showAlert("error", "There must be an award amount!");
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
