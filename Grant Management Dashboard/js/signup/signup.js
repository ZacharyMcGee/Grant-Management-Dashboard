document.getElementById("username").addEventListener('input', function (evt) {
  checkUsername();
});

document.getElementById("email").addEventListener('input', function (evt) {
  checkEmail();
});

document.getElementById("confirmpassword").addEventListener('input', function (evt) {
  checkPasswordMatch();
});

// Ugly, Should fix later
function validateForm() {
  $.ajax({url: "functions/username-availability.php", type: "post", data: {username: document.getElementById("username").value }, success: function(result){
      if(result == "0"){
        if(document.getElementById("username").classList.length > 0){
          document.getElementById("username").classList.remove("bad");
        }
        document.getElementById("bad-icon-user").classList.remove("visible");
        document.getElementById("bad-icon-user").classList.add("hidden");
        if(checkEmail()){
          if(checkPasswordMatch()){
            $.ajax({url: "functions/create-account.php", type: "post", data: {username: document.getElementById("username").value, email: document.getElementById("email").value, password: document.getElementById("password").value, }, success: function(result){
              showAlert("success", "Account successfully created!");
              setTimeout(function(){ document.location = ("index.php"); }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showAlert("error", "There was an error, try again.");
            }});
          }
          else
          {
              showAlert("error", "Your passwords must match!");
          }
        }
        else
        {
            showAlert("error", "Please enter a valid email!");
        }
      }
      else {
        showAlert("error", "Username is already taken!");
        document.getElementById("username").classList.add("bad");
        document.getElementById("bad-icon-user").classList.remove("hidden");
        document.getElementById("bad-icon-user").classList.add("visible");
        return false;
      }
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log("1");
  }});
}

function checkUsername() {
  $.ajax({url: "functions/username-availability.php", type: "post", data: {username: document.getElementById("username").value }, success: function(result){
      if(result == "0"){
        if(document.getElementById("username").classList.length > 0){
          document.getElementById("username").classList.remove("bad");
        }
        document.getElementById("bad-icon-user").classList.remove("visible");
        document.getElementById("bad-icon-user").classList.add("hidden");
        return true;
      }
      else {
        document.getElementById("username").classList.add("bad");
        document.getElementById("bad-icon-user").classList.remove("hidden");
        document.getElementById("bad-icon-user").classList.add("visible");
        return false;
      }
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log("1");
  }});
}

function checkEmail() {
  if(validateEmail()){
    if(document.getElementById("email").classList.length > 0){
      document.getElementById("email").classList.remove("bad");
    }
    document.getElementById("bad-icon-email").classList.remove("visible");
    document.getElementById("bad-icon-email").classList.add("hidden");
    return true;
  }
  else {
    document.getElementById("email").classList.add("bad");
    document.getElementById("bad-icon-email").classList.remove("hidden");
    document.getElementById("bad-icon-email").classList.add("visible");
    return false;
  }
}

function validateEmail() {
  var email = document.getElementById("email").value;
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function checkPasswordMatch() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmpassword").value;

    if (password == confirmPassword) {
      if(document.getElementById("password").classList.length > 0 && document.getElementById("confirmpassword").classList.length > 0){
        document.getElementById("password").classList.remove("bad");
        document.getElementById("confirmpassword").classList.remove("bad");
      }
      document.getElementById("bad-icon-pass").classList.remove("visible");
      document.getElementById("bad-icon-pass").classList.add("hidden");
      document.getElementById("bad-icon-confirm").classList.remove("visible");
      document.getElementById("bad-icon-confirm").classList.add("hidden");
      return true;
    }
    else
    {
      document.getElementById("password").classList.add("bad");
      document.getElementById("confirmpassword").classList.add("bad");
      document.getElementById("bad-icon-pass").classList.remove("hidden");
      document.getElementById("bad-icon-pass").classList.add("visible");
      document.getElementById("bad-icon-confirm").classList.remove("hidden");
      document.getElementById("bad-icon-confirm").classList.add("visible");
      return false;
    }
}

function showAlert(type, message) {
      var x = document.getElementById("alertbar")

      switch(type){
        case "error":
          x.innerHTML = "<p><i class='fas fa-exclamation-circle'></i> " + message + "</p>"
          x.classList.remove("success-alert");
          x.classList.add("error-alert");
          break;
        case "alert":
          x.innerHTML = "<p><i class='fas fa-exclamation-triangle'></i> " + message + "</p>"
          x.classList.remove("success-alert");
          x.classList.add("warning-alert");
          break;
        case "success":
          x.innerHTML = "<p><i class='fas fa-check-circle'></i> " + message + "</p>"
          x.classList.remove("warning-alert");
          x.classList.remove("error-alert");
          x.classList.add("success-alert");
          break;
        default:
          break;
      }
      x.classList.add("show");
      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
