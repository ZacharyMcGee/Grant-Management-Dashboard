  /////////////////////////////////////
 /*           CHART PLUGINS         */
/////////////////////////////////////

// Text in middle of Doughnut Chart
Chart.pluginService.register({
  beforeDraw: function (chart) {
    if (chart.config.options.elements.center) {
      //Get ctx from string
      var ctx = chart.chart.ctx;

      //Get options from the center object in options
      var centerConfig = chart.config.options.elements.center;
      var fontStyle = centerConfig.fontStyle || 'Arial';
      var txt = centerConfig.text;
      var color = centerConfig.color || '#000';
      var sidePadding = centerConfig.sidePadding || 20;
      var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
      //Start with a base font of 30px
      ctx.font = "30px " + fontStyle;

      //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
      var stringWidth = ctx.measureText(txt).width;
      var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

      // Find out how much the font can grow in width.
      var widthRatio = elementWidth / stringWidth;
      var newFontSize = Math.floor(30 * widthRatio);
      var elementHeight = (chart.innerRadius * 2);

      // Pick a new font size so it will not be larger than the height of label.
      var fontSizeToUse = Math.min(newFontSize, elementHeight);

      //Set font settings to draw it correctly.
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
      var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
      ctx.font = fontSizeToUse+"px " + fontStyle;
      ctx.fillStyle = color;

      //Draw text in center
      ctx.fillText(txt, centerX, centerY);
    }
  }
});

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
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / New Grant</p>");
        document.getElementById('file-upload')
        .addEventListener('change', readSingleFile, false);
    }});
});

$("#view-grants").click(function(){
    $.ajax({url: "includes/grants/view-grants.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / View Grants</p>");
    }});
});

$("#dash-home").click(function(){
    $.ajax({url: "includes/dashboard/dashboard.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Dashboard Home</p>");
    }});
});

$("#custom").click(function(){
    $.ajax({url: "includes/dashboard/custom.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Customize</p>");
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

$("#search-bar").click(function(){
  console.log("HEYYY");
  var currentClass = $('#search-bar-input').attr('class');
  if(currentClass == "search-bar-input"){
    $("#search-bar-input").attr('class', 'search-bar-input-open');
  }
  else {
    $("#search-bar-input").attr('class', 'search-bar-input');
  }
});

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
    result = JSON.stringify(result);
    result = result.split(String.fromCharCode(92)).join(String.fromCharCode(92,92));

    result = result.replace(/'/g, "");
    sessionStorage.setItem("result", result);
    console.log(sessionStorage.getItem("result"));
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

function calculateNetDirectCostLeft(awardAmount, netDirectCostExpenditures){
  return (awardAmount - netDirectCostExpenditures).toFixed(2);
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



function moneyLeftPieChart(id, award, jsondata){
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  console.log(award + " and ");
  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);
  var amountLeft = calculateNetDirectCostLeft(award, netDirectCostExpenditures);

  var ctx = document.getElementById(id).getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'doughnut',
      // The data for our dataset
      data: {
          labels: ["Spent", "Remaining"],
          datasets: [{
              data: [netDirectCostExpenditures, amountLeft],
              backgroundColor: [
                'rgb(230,230,230)',
                'rgb(96,202,119)',
              ]
          }]
      },

      // Configuration options go here
      options: {
        cutoutPercentage: 70,
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 1,
        elements: {
            center: {
            text: "$" + amountLeft,
            color: '#60ca77',
            fontStyle: 'Helvetica',
            sidePadding: 25
          }
        },
        legend: {
           display: false,
        },
      }
  });
}

function openGrant(id) {
  $("#content").load("includes/grants/grant.php?id=" + id);
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
