<?php
session_start();
require_once '../../config.php';
// Create connection
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT name, username, email FROM accounts WHERE id=" . $_SESSION['id'];
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $username = $row["username"];
        $name = $row["name"];
        $email = $row["email"];
    }
} else {
    $username = "Unavailable";
}
$con->close();
?>
<head>
  <script type="text/javascript">

  $("#profile-save").click(function(){
    if(validateSaveChanges()){
      var profileEmail = document.getElementById('input-email').value;
      var profileUserName = document.getElementById('input-un').value;
      var profilePass = document.getElementById('input-pass').value;
      var profileName = document.getElementById('input-name').value;



console.log(sessionStorage.getItem("result"));
$.ajax({
      url: "functions/save-profile.php",
      type: "post",
      data: { 'name' : profileName, 'un' : profileUserName, 'email' : profileEmail, 'password' : profilePass } ,
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

$("#profile-cancel").click(function(){
  $.ajax({url: "includes/dashboard/dashboard.php", success: function(result){
      $("#content").html(result);
      $("#breadcrumbs").html("<p>Home / Dashboard</p>");
  }});
});

$("#profileImage").click(function(e) {
    $("#imageUpload").click();
});

function fasterPreview( uploader ) {
    if ( uploader.files && uploader.files[0] ){
          $('#profileImage').attr('src',
             window.URL.createObjectURL(uploader.files[0]) );
    }
}

$("#imageUpload").change(function(){
    fasterPreview( this );
});

function validateSaveChanges(){
  var profilePassForm = document.getElementById('input-pass');
  var profileConfirmForm = document.getElementById('input-confirm');

  if(profilePassForm.value != profileConfirmForm.value){
    showAlert("error", "The passwords you entered do not match!");
    return false;
  }
  return true;
}

  </script>
</head>

<div class="edit-profile-container">
  <div class="full-card">
    <div class="card-title">
  		<div class="card-title-text">
  			<i class="fasfa-list"></i><span class="parent-link">Edit Profile</span>
  		</div>
  	</div>
  <div class="left-half">
    <div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <div class="profile-container" id="profile-container">
        <image id="profileImage" src="images/boyd.jpg" />
      </div>
      <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required="" capture>
      <h3>Profile Picture</h3>
    </div>
  </div>
  <div class="right-half">
    <h3>Personal info</h3>
    <div>
      <label class="font">Name:</label>
      <div class="input-grant-input-container">
        <i class="fas fa-user-circle"></i>
        <input class="input-text" id="input-name" type="text" value="<?php echo  $name ?>" placeholder="Name">
      </div>
    </div>
    <div>
      <label class="font">Email:</label>
        <div class="input-grant-input-container">
        <i class="far fa-envelope"></i>
        <input class="input-text" id="input-email" type="text" value="<?php echo  $email ?>" placeholder="email@test.com">
      </div>
    </div>
    <label class="font">Username:</label>
    <div class="input-grant-input-container">
      <i class="fas fa-users"></i>
        <input class="input-text" id="input-un" type="text" value="<?php echo  $username ?>" placeholder="Username">
    </div>
    <div>
      <label class="font">Password:</label>
      <div class="input-grant-input-container">
        <i class="fas fa-lock"></i>
        <input class="input-text" id="input-pass" type="password" value="" placeholder="New Password">
      </div>
    </div>
    <label class="font">Confirm Password:</label>
    <div class="input-grant-input-container">
      <i class="fas fa-user-check"></i>
        <input class="input-text" id="input-confirm" type="password" value="" placeholder="New Password">
    </div>
    <div>
      <label></label>
      <div>
        <input style="margin-right: 53px;" type="button" id="profile-save" class="save-button" value="Save Changes">
        <span></span>
        <input type="reset" id="profile-cancel" class="cancel-button" value="Cancel">
      </div>
    </div>
</div>
</div>
</div>
