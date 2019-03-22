<!DOCTYPE html>
<html>
<head>
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
    width: 400px;
}

.images {
  float:left;
}

.font{
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  text-decoration: none;
}

</style>
<body>


<div class="container">
  <div class="left-half">
    <h1>Edit Profile</h1>
    <div>
      <img src="//placehold.it/400" class="images" alt="avatar">
      <label for="file-uploa" class="custom-file-upload">
          Select File
      </label>
      <input id="file-uploa" type="file"/>
    </div>
  </div>
  <div class="right-half">
    <h3>Personal info</h3>
    <div>
      <label class="font">Name:</label>
      <div class="input-grant-input-container">
        <i class="fas fa-user-circle"></i>
        <input class="input-text" type="text" value="First">
      </div>
    </div>
    <div>
      <div class="input-grant-input-container">
        <i class="fas fa-user-circle"></i>
        <input class="input-text" type="text" value="Last">
      </div>
    </div>
    <div>
      <label class="font">Email:</label>
        <div class="input-grant-input-container">
        <i class="far fa-envelope"></i>
        <input class="input-text" type="text" value="janesemail@gmail.com">
      </div>
    </div>
    <label class="font">Username</label>
    <div class="input-grant-input-container">
      <i class="fas fa-users"></i>
        <input class="input-text" type="text" value="janeuser">
    </div>
    <div>
      <label class="font">Password:</label>
      <div class="input-grant-input-container">
        <i class="fas fa-lock"></i>
        <input class="input-text" type="password" value="11111122333">
      </div>
    </div>
    <label class="font">Confirm Password</label>
    <div class="input-grant-input-container">
      <i class="fas fa-user-check"></i>
        <input class="input-text" type="password" value="11111122333">
    </div>
    <div>
      <label></label>
      <div>
        <input type="button" class="save-button" value="Save Changes">
        <span></span>
        <input type="reset" class="cancel-button" value="Cancel">
      </div>
    </div>
</div>
</div>
</body>
</html>
