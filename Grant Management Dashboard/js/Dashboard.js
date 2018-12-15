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
  var reader = new FileReader();
  reader.readAsBinaryString(file);

  reader.onload = function(e) {
    var contents = e.target.result;
    loadExcel(contents);
  };
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
    buildHtmlTable('#excelDataTable', result)
    console.log(result[0].Description);
    console.log(result);
}

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
  return columnSet;
}
