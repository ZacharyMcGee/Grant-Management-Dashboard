  /////////////////////////////////////
 /*           ACCORDION MENU        */
/////////////////////////////////////

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

  /////////////////////////////////////
  /*    ACCORDION MENU BUTTONS      */
/////////////////////////////////////
//         DASHBOARD
//         - customize
//         GRANTS
//         - new grant
//         - view grants
////////////////////////////////////

/* NEW GRANT BUTTON */

$("#new-grant").click(function(){
    $.ajax({url: "includes/grants/new-grant.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p>Home / New Grant</p>");
        document.getElementById('file-upload')
        .addEventListener('change', readSingleFile, false);
    }});
});

$("#view-grants").click(function(){
    $.ajax({url: "includes/grants/view-grants.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p>Home / View Grants</p>");
    }});
});

  /////////////////////////////////////
 /*      MAKE PAGE FULL SCREEN      */
/////////////////////////////////////
function openFullscreen() {
  var elem = document.documentElement;
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) { /* Firefox */
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE/Edge */
    document.msExitFullscreen();
  }
}

  /////////////////////////////////////
 /*      READ EXCEL FILE DATA       */
/////////////////////////////////////

function readSingleFile(e) {
  // IF WE SELECTED THE FILE FROM BUTTON THEN HANDLE THIS WAY
  if(e.type == "change"){
  var file = e.target.files[0];
    if (!file) {
      return;
    }
  }
  else // ELSE, IT MUST BE FROM DRAG AND DROP, HANDLE THIS WAY
  {
    var file = e.dataTransfer.files[0];
    if(!file) {
      return;
    }
  }
  // CHECK IF THE FILE IS OF TYPE XLSX
  if(validateFileType(file)){
    var dragarea = document.getElementById('drag-and-drop');
    dragarea.classList.add('dropped');
    var reader = new FileReader();
    reader.readAsBinaryString(file);

    reader.onload = function(e) {
      var contents = e.target.result;
      loadExcel(contents);
    };
  }
}

  /////////////////////////////////////
 /*      VALIDATE THE FILETYPE      */
/////////////////////////////////////

function validateFileType(file) {
  var fileTypes = ['xlsx']; // FILETYPES WE ALLOW (XLSX ONLY)
  var extension = file.name.split('.').pop().toLowerCase(),
  isSuccess = fileTypes.indexOf(extension) > -1;
  if (isSuccess) {
      return true;
  }
  else
  {
    showAlert("error", "File types must be of type: 'xlsx'")
    return false;
  }
}

  /////////////////////////////////////
 /* TURN EXCEL DATA TO JSON & LOAD  */
/////////////////////////////////////

function loadExcel(contents){

    /* Call XLSX */
    var workbook = XLSX.read(contents, {
        type: "binary"
    });

    /* DO SOMETHING WITH workbook HERE */
    var first_sheet_name = workbook.SheetNames[0];
    /* Get worksheet */
    var worksheet = workbook.Sheets[first_sheet_name];
    var result = XLSX.utils.sheet_to_json(worksheet, {
        raw: true
    });
    document.getElementById('drag-and-drop').innerHTML = "<div class='excelData'><table id='excelDataTable' class='excelDataTable'></table></div>";
    buildHtmlTable('#excelDataTable', result);
    var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(result);
    var totalDirectCostRefunds = calculateTotalDirectCostRefunds(result);
    var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);
    console.log(totalDirectCostExpenditures);
    console.log(totalDirectCostRefunds);
    console.log(netDirectCostExpenditures);
    sessionStorage.setItem("result", JSON.stringify(result).replace(/'/g, ""));
    //console.log(JSON.parse(sessionStorage.getItem("result")));
}

function calculateTotalDirectCostExpenditures(obj){
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(!obj[i]["Headers Category"].includes("24") && !obj[i]["Headers Category"].includes("63")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculateTotalDirectCostRefunds(obj){
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(!obj[i]["Headers Category"].includes("24") && !obj[i]["Headers Category"].includes("63") && !obj[i]["Headers Category"].includes("62")){
      total += obj[i]["Credit Amount"];
    }
  }
  return total;
}

function calculateNetDirectCostExpenditures(expenditures, refunds){
  return (expenditures - refunds).toFixed(2);
}

  /////////////////////////////////////
 /* BUILD HTML TABLE FROM JSON DATA */
/////////////////////////////////////

function buildHtmlTable(selector, excelData) {
  var columns = addAllColumnHeaders(excelData, selector);

  for (var i = 0; i < excelData.length; i++) {
    var row$ = $('<tr/>');
    for (var colIndex = 0; colIndex < columns.length; colIndex++) {
      var cellValue = excelData[i][columns[colIndex]];
      if (cellValue == null) cellValue = "";
      row$.append($('<td/>').html(cellValue));
    }
    $(selector).append(row$);
  }
}

function addAllColumnHeaders(excelData, selector) {
  var columnSet = [];
  var headerTr$ = $('<tr/>');

  for (var i = 0; i < excelData.length; i++) {
    var rowHash = excelData[i];
    for (var key in rowHash) {
      if ($.inArray(key, columnSet) == -1) {
        columnSet.push(key);
        headerTr$.append($('<th/>').html(key));
      }
    }
  }

  $(selector).append(headerTr$);
  str = 'hey what is;going on there;'
  runCommands(str);
  return columnSet;

}

function runCommands(string){
  var commands = string.split(';');
  //for(var i = 0; i < commands.length; i++){
    //tokens = commands[i].split(' ');
  //}
  //print(commands);
  //print(tokens);

}



function createChart(){
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'line',

      // The data for our dataset
      data: {
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'rgb(255, 99, 132)',
              borderColor: 'rgb(255, 99, 132)',
              data: [0, 10, 5, 2, 20, 30, 45],
          }]
      },

      // Configuration options go here
      options: {}
  });
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
