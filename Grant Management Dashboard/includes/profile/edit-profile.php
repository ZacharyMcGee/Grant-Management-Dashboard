<head>
  <script type="text/javascript">
  //var photoInput = document.getElementById('photo-upload');

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
  var profileNameForm = document.getElementById('input-name');
  var profileUserNameForm = document.getElementById('input-un');
  var profileEmailForm = document.getElementById('input-email');

  if(profilePassForm.value != profileConfirmForm.value){
    showAlert("error", "The passwords you entered do not match!");
    return false;
  }

  if((profileNameForm.value == "name") && (profileUserNameForm.value == "username") && (profileEmailForm.value == "email@test.com") && (profilePassForm.value == "11111122333"))
  {
    showAlert("error", "Nothing has been changed!");
    return false;
  }
  //still need to only send what is changed

  return true;
}

  </script>
  <style>
* {
  box-sizing: border-box;
}

.container {
  background-color: #FFF;
  display: table;
  width: 100%;
}

.left-half {
    text-align: justify;
    width: 300px;
    float: left;
    display: block;
}

.left-half h1 {
  margin: 0px;
  padding: 0px;
}

.right-half {
  width: calc(100% - 300px);
  float: left;
  display: block;
}

.images {
  float:left;
}

.font{
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  text-decoration: none;
}

#imageUpload
{
    display: none;
}

#profileImage
{
    cursor: pointer;
}

#profile-container {
  margin-top: 20px;
  margin-left: 50px;
  width: 150px;
  height: 150px;
  overflow: hidden;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  -o-border-radius: 50%;
  border-radius: 50%;
}

#profile-container img {
    width: 150px;
    height: 150px;
}

</style>
</head>

<div class="container" style="padding-bottom: 20px;">
  <div class="full-card">
    <div class="card-title" style="height: 41px;">
  		<div class="card-title-text">
  			<i class="fas fa-list" style="color:#7d7d7d;"></i><span class="parent-link">Edit Profile</span>
  		</div>
  	</div>
  <div class="left-half">
    <div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <div class="profile-container" id="profile-container">
        <image id="profileImage" src="images/boyd.jpg" />
      </div>
      <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required="" capture>
      <h3 style="margin-left:70px; font-weight:400;">Profile Picture</h3>
    </div>
  </div>
  <div class="right-half">
    <h3 style="font-weight: 400;margin-bottom: 10px;border-bottom: 1px solid #e6e6e6;margin-right: 55px;">Personal info</h3>
    <div>
      <label class="font">Name:</label>
      <div class="input-grant-input-container">
        <i class="fas fa-user-circle"></i>
        <input class="input-text" id="input-name" type="text" value="Boyd Goodson">
      </div>
    </div>
    <div>
      <label class="font">Email:</label>
        <div class="input-grant-input-container">
        <i class="far fa-envelope"></i>
        <input class="input-text" id="input-email" type="text" value="email@test.com">
      </div>
    </div>
    <label class="font">Username</label>
    <div class="input-grant-input-container">
      <i class="fas fa-users"></i>
        <input class="input-text" id="input-un" type="text" value="username">
    </div>
    <div>
      <label class="font">Password:</label>
      <div class="input-grant-input-container">
        <i class="fas fa-lock"></i>
        <input class="input-text" id="input-pass" type="password" value="11111122333">
      </div>
    </div>
    <label class="font">Confirm Password</label>
    <div class="input-grant-input-container">
      <i class="fas fa-user-check"></i>
        <input class="input-text" id="input-confirm" type="password" value="11111122333">
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
