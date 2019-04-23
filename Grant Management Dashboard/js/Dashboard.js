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
//         TASKS
//         - calendar
////////////////////////////////////

/* NEW GRANT BUTTON */

function setBreadcrumb(breadcrumb) {
  $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / " + breadcrumb + "</p>");
}

$("#new-grant").click(function(){
    $.ajax({url: "includes/grants/new-grant.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / New Grant</p>");
        document.getElementById('file-upload')
        .addEventListener('change', readSingleFile, false);
    }});
});

$("#view-grants").click(function(){
  openViewGrants();
});

function openViewGrants() {
  $.ajax({url: "includes/grants/view-grants.php", success: function(result){
      $("#content").html(result);
      $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / View Grants</p>");
  }});
}

$("#dash-home").click(function(){
  openGrantHome();
});

function openGrantHome() {
  $.ajax({url: "includes/dashboard/dashboard.php", success: function(result){
      $("#content").html(result);
      $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Dashboard</p>");
  }});
}

$("#edit-profile").click(function(){
  $.ajax({url: "includes/profile/edit-profile.php", success: function(result){
      $("#content").html(result);
      $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Edit Profile</p>");
    }});
  });

$("#custom").click(function(){
    $.ajax({url: "includes/dashboard/custom.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Customize</p>");
    }});
});

$("#spending-analyizer").click(function(){
    $.ajax({url: "includes/analytics/spending-analytics.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Spending Trends</p>");
    }});
});

$("#calendar").click(function(){
    $.ajax({url: "includes/tasks/calendar.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Schedule Alert</p>");
    }});
});

/////////////////////////////////////
/*      NOTIFICATIONS SYSTEM       */
/*  DEADLINES AND GRANT REMINDERS  */
/////////////////////////////////////

$("#notifications-print").click(function(){
    $.ajax({url: "includes/tasks/notifications-system.php", success: function(result){
        $("#content").html(result);
    }});
});

    /////////////////////////////////////
  /*      SEARCH FUNCTIONALITY       */
/////////////////////////////////////

document.getElementById("search-bar-input").addEventListener('input', function (evt) {
  $.ajax({url: "includes/extras/search.php", type: "post", data: {search: document.getElementById("search-bar-input").value }, success: function(result){
      $("#content").html(result);
  }});
});

function clearSearch() {
  $("#search-bar-input").val("");
}

function cancelSearch() {
  clearSearch();
  $("#search-bar-input").attr('class', 'search-bar-input');
  $("#search-bar-cancel").toggleClass('disabled');
  $("#search-bar-cancel-text").toggleClass('disabled');
  openGrantHome();
}

$("#search-bar").click(function(){
  var currentClass = $('#search-bar-input').attr('class');
  if(currentClass == "search-bar-input"){
    $("#search-bar-input").attr('class', 'search-bar-input-open');
    $("#search-bar-cancel").toggleClass('disabled');
    $("#search-bar-cancel-text").toggleClass('disabled');
  }
  else {
    $("#search-bar-input").attr('class', 'search-bar-input');
    $("#search-bar-cancel").toggleClass('disabled');
    $("#search-bar-cancel-text").toggleClass('disabled');
  }
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

function openDropdown(id) {
  document.getElementById(id).classList.toggle("show-dropdown");
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
      document.getElementById('small-hint').innerHTML = "(" + file.name + ")";
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

    document.getElementById("input-bp").value = result[0]["Budget Purpose"];

    result = JSON.stringify(result);
    result = result.split(String.fromCharCode(92)).join(String.fromCharCode(92,92));

    result = result.replace(/'/g, "");
    sessionStorage.setItem("result", result);
    //console.log(sessionStorage.getItem("result"));
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

function calculateTotalIndirectCostExpenditures(obj){
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Category"].includes("24")){
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

function calculateTotalIndirectCostRefunds(obj){
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Category"].includes("24")){
      total += obj[i]["Credit Amount"];
    }
  }
  return total;
}

function calculateNetDirectCostExpenditures(expenditures, refunds){
  return (expenditures - refunds).toFixed(2);
}

function calculateNetIndirectCostExpenditures(expenditures, refunds){
  return (expenditures - refunds).toFixed(2);
}

function calculateNetDirectCostLeft(awardAmount, netDirectCostExpenditures){
  return (awardAmount - netDirectCostExpenditures).toFixed(2);
}

function calculateNetIndirectCostLeft(awardAmount, netDirectCostExpenditures){
  return (awardAmount - netDirectCostExpenditures).toFixed(2);
}

function calculatePayableExpenditures(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Source"].includes("Payables") || obj[i]["Headers Source"].includes("Manual") || obj[i]["Headers Category"].includes("29")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculatePayableRefunds(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Source"].includes("Payables") || obj[i]["Headers Source"].includes("Manual") || obj[i]["Headers Category"].includes("29")){
      total += obj[i]["Credit Amount"];
    }
  }
  return total;
}

function calculateNetPayables(expenditures, refunds) {
  return expenditures - refunds;
}

function calculatePayrollExpenditures(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Source"].includes("Payroll")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculatePayrollRefunds(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Source"].includes("Payroll")){
      total += obj[i]["Credit Amount"];
    }
  }
  return total;
}

function calculateNetPayrolls(expenditures, refunds) {
  return expenditures - refunds;
}

function calculateAdjustmentExpenditures(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Category"].includes("Adjustment")){
      total += obj[i]["Debit Amount"];
    }
  }
  console.log(total);
  return total;
}

function calculateAdjustmentRefunds(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Category"].includes("Adjustment")){
      total += obj[i]["Credit Amount"];
    }
  }
  console.log(total);
  return total;
}

function calculateNetAdjustments(expenditures, refunds) {
  return expenditures - refunds;
}

function calculateFringe(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Object"].includes("4384") || obj[i]["Object"].includes("4344") || obj[i]["Object"].includes("4536")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculateSalaryExpenditures(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Category"].includes("Adjustment") || obj[i]["Headers Category"].includes("127") || obj[i]["Headers Category"].includes("128") || obj[i]["Headers Category"].includes("129") || obj[i]["Headers Category"].includes("130") || obj[i]["Headers Category"].includes("55")  || obj[i]["Headers Category"].includes("29")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculateSalaryRefunds(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Category"].includes("Adjustment") || obj[i]["Headers Category"].includes("127") || obj[i]["Headers Category"].includes("128") || obj[i]["Headers Category"].includes("129") || obj[i]["Headers Category"].includes("130") || obj[i]["Headers Category"].includes("55")  || obj[i]["Headers Category"].includes("29")){
      total += obj[i]["Credit Amount"];
    }
  }
  return total;
}

function calculateSalaryTotal(expenditures, refunds) {
  return expenditures - refunds;
}

function calculatePrimaryCareFee(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Object"].includes("5652")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculateEquipment(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Headers Source"].includes("Payables") && obj[i]["Debit Amount"] > 5000){
      for(var j = 0; j < obj.length; j++) {
        if(obj[j]["Batches Reference"] == obj[i]["Batches Reference"] && obj[i] != obj[j]){
          total += obj[j]["Debit Amount"];
        }
      }
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
}

function calculateTravel(obj) {
  var total = 0;
  for(var i = 0; i < obj.length; i++){
    if(obj[i]["Object"].includes("4386") || obj[i]["Object"].includes("4382") || obj[i]["Object"].includes("4322") || obj[i]["Object"].includes("4326") || obj[i]["Object"].includes("5192")){
      total += obj[i]["Debit Amount"];
    }
  }
  return total;
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
  return columnSet;
}

function addDataLinearTime(chartID) {

  var newData = [{x: "04/01/2015", y: 135}];

linearTimeChart.data.datasets[0].data.push(newData);
linearTimeChart.update();
  console.log(linearTimeChart);
}

function dateFormatChange(date) {
  date = date.replace("-", "/");
  date = date.replace("-", "/");
  date = date.replace("Jan", "01");
  date = date.replace("Feb", "02");
  date = date.replace("Mar", "03");
  date = date.replace("Apr", "04");
  date = date.replace("May", "05");
  date = date.replace("Jun", "06");
  date = date.replace("Jul", "07");
  date = date.replace("Aug", "08");
  date = date.replace("Sep", "09");
  date = date.replace("Oct", "10");
  date = date.replace("Nov", "11");
  date = date.replace("Dec", "12");
  return date;
}

function sortByDate(arr) {
  var dateA = arr[1].getTime();
  var dateB = arr[1].getTime();
  return dateA > dateB ? 1 : -1;
  }

function linearTimeChart(jsondata, dc_award, idc_award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);

  var dcdataset = [];
  var idcdataset = [];

  var dctotal = 0;
  for(var i = 0; i < jsondata.length; i++){
    if(!jsondata[i]["Headers Category"].includes("24") && !jsondata[i]["Headers Category"].includes("63") && !jsondata[i]["Headers Category"].includes("62")){
      dctotal += jsondata[i]["Credit Amount"];
    }
  }

  dc_award = +dc_award + +dctotal;

  var idctotal = 0;
  for(var i = 0; i < jsondata.length; i++){
    if(jsondata[i]["Headers Category"].includes("24")){
      idctotal += jsondata[i]["Credit Amount"];
    }
  }

  idc_award = +idc_award + +idctotal;

  for(var i = 0; i < jsondata.length; i++){
    if(!jsondata[i]["Headers Category"].includes("24") && !jsondata[i]["Headers Category"].includes("63")){
      var date = dateFormatChange(jsondata[i]["Ledger Date"]);
      var dateSplit = date.split("/");
      dateSplit[2] = "20" + dateSplit[2];
      var dateFormat = new Date(dateSplit[2] + "-" + (dateSplit[1]) + "-" + dateSplit[0]);
      var data = { x: dateFormat, y: jsondata[i]["Debit Amount"], debit: jsondata[i]["Debit Amount"]};
      dcdataset.push(data);
    }
    else if(jsondata[i]["Headers Category"].includes("24")){
      var date = dateFormatChange(jsondata[i]["Ledger Date"]);
      var dateSplit = date.split("/");
      dateSplit[2] = "20" + dateSplit[2];
      var dateFormat = new Date(dateSplit[2] + "-" + (dateSplit[1]) + "-" + dateSplit[0]);
      var data = { x: dateFormat, y: jsondata[i]["Debit Amount"], debit: jsondata[i]["Debit Amount"]};
      idcdataset.push(data);
    }
  }

  dcdataset.sort(function(a,b){
    var c = new Date(a.x);
    var d = new Date(b.x);
    return c-d;
  });
  for(var i = 0; i < dcdataset.length; i++) {
    dc_award = dc_award - dcdataset[i].y;
    dcdataset[i].y = dc_award;
  }

  idcdataset.sort(function(a,b){
    var c = new Date(a.x);
    var d = new Date(b.x);
    return c-d;
  });
  for(var i = 0; i < idcdataset.length; i++) {
    idc_award = idc_award - idcdataset[i].y;
    idcdataset[i].y = idc_award;
  }
  console.log(dcdataset);
  console.log(dcdataset[0].x);
  var ctx = document.getElementById('timeChart').getContext('2d');
   var linearTimeChart = new Chart(ctx, {
    type: 'line',
    data: {
      datasets: [
    {
        label: ["Direct Cost"],
        data: dcdataset,
        fill: false,
        borderColor: 'rgb(96,202,119)',
        lineTension: 0,
        backgroundColor: "rgba(75,192,192,0.4)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderWidth: 2,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 3,
        pointHitRadius: 10,
        spanGaps: false
    },
    {
        label: ["Indirect Cost"],
        data: idcdataset,
        fill: false,
        borderColor: 'rgb(255,99,132)',
        lineTension: 0,
        backgroundColor: "rgba(255,99,132,.4)",
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderWidth: 2,
        borderJoinStyle: 'miter',
        pointBorderColor: "rgb(255,99,132)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(255,99,132,1)",
        pointHoverBorderColor: "rgba(255,99,132,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 3,
        pointHitRadius: 10,
        spanGaps: false
    }
]
    },
    options: {
        scales: {
          xAxes: [
                  {
                    scaleLabel: {
                      display: true
                    },
                    type: "time",
                    time: {
                      unit: "month",
                      displayFormats: {
                        month: "MMM-YYYY"
                      }
                    },
                    position: "bottom"
                  }
                ],
            yAxes: [{
                ticks: {
                  beginAtZero: true,   // minimum value will be 0.
                  callback: function(value, index, values) {
                      return '$' + value.toFixed(2);;
                  }
                }
            }]
        },
        title: {
          display: true,
          text:'Spending Timeline'
        },
        legend: {
          display: true,
        },
        pan: {
          enabled: true,
          drag: true,
          mode: "xy",
          speed: 10,
          threshold: 0
        },
        zoom: {
          enabled: true,
          drag: false,
          mode: "xy",
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                  if(tooltipItem.datasetIndex == 0) {
                    var debit = moneyFormat(data.datasets[0].data[tooltipItem.index].debit);
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label = ' Debit: -' + debit + ', DC Remaining: ';
                    }
                    label += moneyFormat(Math.round(tooltipItem.yLabel * 100) / 100);
                    return label;
                  }
                  else
                  {
                    var debit = moneyFormat(data.datasets[1].data[tooltipItem.index].debit);
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label = ' Debit: -' + debit + ', IDC Remaining: ';
                    }
                    label += moneyFormat(Math.round(tooltipItem.yLabel * 100) / 100);
                    return label;
                  }
                },
                title: function(tooltipItems, data) {
                  var newDate = tooltipItems[0].xLabel.split(" ");
                  return 'Transaction Date: ' + newDate[0] + " "  + newDate[1] + " " + newDate[2];
                },
            }
        },
        //onClick: function(event, element) {
        //  var activeElement = element[0];
        //  var data = activeElement._chart.data;
        //  var barIndex = activeElement._index;
        //  var datasetIndex = activeElement._datasetIndex;
        //  console.log(activeElement);
        //  var datasetLabel = data.datasets[datasetIndex].label;
        //  var xLabel = data.labels[barIndex];
        //  var yLabel = data.datasets[datasetIndex].data[barIndex];

        //  console.log(yLabel);
        //}
    }
  })
}

function linearTimeChart2(idata) {
  console.log(idata);
  var ctx = document.getElementById('timeChart').getContext('2d');
   var linearTimeChart = new Chart(ctx, {
    type: 'line',
    data: {
      datasets: [
    {
        label: "Direct Cost Remaining",
        data: [idata[0]],
        fill: 0,
        //backgroundColor: 'rgb(182, 237, 194)',
        borderColor: 'rgb(96,202,119)'
    },
]
    },
    options: {
        scales: {
            xAxes: [{
                type: 'time',
                distribution: 'linear',
            }],
            yAxes: [{
                ticks: {
                  beginAtZero: true,   // minimum value will be 0.
                  callback: function(value, index, values) {
                      return '$' + value.toFixed(2);;
                  }
                }
            }]
        },
        title: {
          display: true,
          text:'Direct Cost Timeline'
        },
        legend: {
          display: false,
        }
    }
})

for(var i = 0; i < idata.length; i++){
  //console.log(idata[i].y);
  jsondata = idata[i].y;
  jsondata = jsondata.replace(/\\\\/g, '\\');
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);

  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);
  idata[i].y = netDirectCostExpenditures;
  console.log(idata[i].y);
  linearTimeChart.data.datasets[0].data[i + 1] = idata[i];
}
linearTimeChart.update();
}

function pieBreakdown(jsondata) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  console.log(jsondata);
}

function setDCBreakdown(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);
  var amountLeft = calculateNetDirectCostLeft(award, netDirectCostExpenditures);
  document.getElementById("dc-spent").innerHTML = "-" + moneyFormat(netDirectCostExpenditures);
  document.getElementById("dc-remaining").innerHTML = "= " + moneyFormat(amountLeft);
}

function getDCSpent(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);
  var amountLeft = calculateNetDirectCostLeft(award, netDirectCostExpenditures);

  document.getElementById('generate-grant-report').innerHTML = moneyFormat(netDirectCostExpenditures);
}

function getDCRem(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);
  var amountLeft = calculateNetDirectCostLeft(award, netDirectCostExpenditures);

  return moneyFormat(amountLeft);
}

function setIDCBreakdown(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalIndirectCostExpenditures = calculateTotalIndirectCostExpenditures(jsondata);
  var totalIndirectCostRefunds = calculateTotalIndirectCostRefunds(jsondata);
  var netIndirectCostExpenditures = calculateNetIndirectCostExpenditures(totalIndirectCostExpenditures, totalIndirectCostRefunds);
  var amountLeft = calculateNetIndirectCostLeft(award, netIndirectCostExpenditures);
  document.getElementById("idc-spent").innerHTML = "-" + moneyFormat(netIndirectCostExpenditures);
  document.getElementById("idc-remaining").innerHTML = "= " + moneyFormat(amountLeft);
}

function getIDCSpent(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalIndirectCostExpenditures = calculateTotalIndirectCostExpenditures(jsondata);
  var totalIndirectCostRefunds = calculateTotalIndirectCostRefunds(jsondata);
  var netIndirectCostExpenditures = calculateNetIndirectCostExpenditures(totalIndirectCostExpenditures, totalIndirectCostRefunds);
  var amountLeft = calculateNetIndirectCostLeft(award, netIndirectCostExpenditures);

  return moneyFormat(netIndirectCostExpenditures);
}

function getIDCSpent(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalIndirectCostExpenditures = calculateTotalIndirectCostExpenditures(jsondata);
  var totalIndirectCostRefunds = calculateTotalIndirectCostRefunds(jsondata);
  var netIndirectCostExpenditures = calculateNetIndirectCostExpenditures(totalIndirectCostExpenditures, totalIndirectCostRefunds);
  var amountLeft = calculateNetIndirectCostLeft(award, netIndirectCostExpenditures);

  return moneyFormat(amountLeft);
}

function moneyFormat(money) {
    return "$" + money.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function setCategoryBreakdown(jsondata, award) {
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);

  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);

  var payableExpenditures = calculatePayableExpenditures(jsondata);
  var payableRefunds = calculatePayableRefunds(jsondata);
  var payables = calculateNetPayables(payableExpenditures, payableRefunds).toFixed(2);

  var payrollExpenditures = calculatePayrollExpenditures(jsondata);
  var payrollRefunds = calculatePayrollRefunds(jsondata);
  var payrolls = calculateNetPayrolls(payrollExpenditures, payrollRefunds).toFixed(2);

  var adjustmentExpenditures = calculateAdjustmentExpenditures(jsondata);
  var adjustmentRefunds = calculateAdjustmentRefunds(jsondata);
  var adjustments = calculateNetAdjustments(adjustmentExpenditures, adjustmentRefunds).toFixed(2);

  var salaryExpenditures = calculateSalaryExpenditures(jsondata);
  var salaryRefunds = calculateSalaryRefunds(jsondata);
  var salaries = calculateSalaryTotal(salaryExpenditures, salaryRefunds).toFixed(2);

  var fringe = calculateFringe(jsondata).toFixed(2);

  //var sub = subSalary(jsondata);
  var primaryCareFee = calculatePrimaryCareFee(jsondata);
  var equipment = calculateEquipment(jsondata).toFixed(2);
  var travel = calculateTravel(jsondata).toFixed(2);
  var total = salaries + primaryCareFee + equipment + travel;

  var commodities = (netDirectCostExpenditures - salaries - fringe - primaryCareFee - travel - equipment).toFixed(2);

  document.getElementById("salaries").innerHTML = "-" + moneyFormat(payrolls);
  document.getElementById("fringe").innerHTML = "-" + moneyFormat(fringe);
  document.getElementById("persfringe").innerHTML = "-" + moneyFormat(primaryCareFee);
  document.getElementById("travel").innerHTML = "-" + moneyFormat(travel);
  document.getElementById("equipment").innerHTML = "-" + moneyFormat(equipment);
  document.getElementById("commodities").innerHTML = "-" + moneyFormat(commodities);
}

function dcMoneyLeftPieChart(id, award, jsondata){
  console.log("json = " + jsondata);
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

function idcMoneyLeftPieChart(id, award, jsondata){
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  var totalIndirectCostExpenditures = calculateTotalIndirectCostExpenditures(jsondata);
  var totalIndirectCostRefunds = calculateTotalIndirectCostRefunds(jsondata);
  var netIndirectCostExpenditures = calculateNetIndirectCostExpenditures(totalIndirectCostExpenditures, totalIndirectCostRefunds);
  var amountLeft = calculateNetIndirectCostLeft(award, netIndirectCostExpenditures);

  var ctx = document.getElementById(id).getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'doughnut',
      // The data for our dataset
      data: {
          labels: ["Spent", "Remaining"],
          datasets: [{
              data: [netIndirectCostExpenditures, amountLeft],
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

function categoryBreakdownChart(id, jsondata){
  console.log("json = " + jsondata);
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);

  var totalDirectCostExpenditures = calculateTotalDirectCostExpenditures(jsondata);
  var totalDirectCostRefunds = calculateTotalDirectCostRefunds(jsondata);
  var netDirectCostExpenditures = calculateNetDirectCostExpenditures(totalDirectCostExpenditures, totalDirectCostRefunds);

  var payableExpenditures = calculatePayableExpenditures(jsondata);
  var payableRefunds = calculatePayableRefunds(jsondata);
  var payables = calculateNetPayables(payableExpenditures, payableRefunds).toFixed(2);

  var payrollExpenditures = calculatePayrollExpenditures(jsondata);
  var payrollRefunds = calculatePayrollRefunds(jsondata);
  var payrolls = calculateNetPayrolls(payrollExpenditures, payrollRefunds).toFixed(2);

  var adjustmentExpenditures = calculateAdjustmentExpenditures(jsondata);
  var adjustmentRefunds = calculateAdjustmentRefunds(jsondata);
  var adjustments = calculateNetAdjustments(adjustmentExpenditures, adjustmentRefunds).toFixed(2);

  var salaryExpenditures = calculateSalaryExpenditures(jsondata);
  var salaryRefunds = calculateSalaryRefunds(jsondata);
  var salaries = calculateSalaryTotal(salaryExpenditures, salaryRefunds).toFixed(2);

  var fringe = calculateFringe(jsondata).toFixed(2);

  //var sub = subSalary(jsondata);
  var primaryCareFee = calculatePrimaryCareFee(jsondata);
  var equipment = calculateEquipment(jsondata);
  var travel = calculateTravel(jsondata).toFixed(2);
  var total = salaries + primaryCareFee + equipment + travel;

  var commodities = (netDirectCostExpenditures - salaries - fringe - primaryCareFee - travel - equipment).toFixed(2);

  //console.log("Payables: " + payables);
  //console.log("Payrolls: " + payrolls);
  //console.log("Total: " + (parseFloat(payables) + parseFloat(payrolls)));
  //console.log("Adjustments: " + adjustments);
  //console.log("Salaries: " + salaries);
  //console.log("Primary Care Free: " + primaryCareFee);
  //console.log("Equipment: " + equipment);
  //console.log("Travel: " + travel);
  //console.log("Total: " + total);

  var ctx = document.getElementById(id).getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'pie',
      // The data for our dataset
      data: {
          labels: ["Salaries", "Prof. Fringe", "Pers. Fringe", "Equipment", "Travel", "Commodity"],
          datasets: [{
              data: [payrolls, fringe, primaryCareFee, equipment, travel, commodities],
              backgroundColor: [
                'rgb(235, 59, 90)',
                'rgb(45, 152, 218)',
                'rgba(75, 101, 132)',
                'rgba(136, 84, 208)',
                'rgba(32, 191, 107)',
                'rgb(247, 183, 49)',
              ]
          }]
      },

      // Configuration options go here
      options: {
        cutoutPercentage: 0,
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 1,
        legend: {
           display: false,
        },
      }
  });
}

function spendingDayAnalyizer(id, jsondata) {
  var tokens = jsondata.split('][');
  for(var i = 0; i < tokens.length; i++) {
    if(i == 0)
    {
      tokens[i] = tokens[i] + "]";
    }
    else if(i == tokens.length - 1)
    {
      tokens[i] = "[" + tokens[i];
    }
    else
    {
      tokens[i] = "[" + tokens[i] + "]";
    }
    tokens[i] = JSON.parse(tokens[i]);

    var total;

    var sunday = 0;
    var monday = 0;
    var tuesday = 0;
    var wednesday = 0;
    var thursday = 0;
    var friday = 0;
    var saturday = 0;

    for(var j = 0; j < tokens[i].length; j++){
      if(tokens[i][j]["Headers Source"].includes("Payables")){
        var date = dateFormatChange(tokens[i][j]["Ledger Date"]);
        var dateSplit = date.split("/");
        dateSplit[2] = "20" + dateSplit[2];
        var dateFormat = new Date(dateSplit[2] + "-" + (dateSplit[1]) + "-" + dateSplit[0]);
        dateFormat.setHours(24, 0, 0);
        switch(dateFormat.getDay()){
          case 0: sunday++;
            break;
          case 1: monday++;
            break;
          case 2: tuesday++;
            break;
          case 3: wednesday++;
            break;
          case 4: thursday++;
            break;
          case 5: friday++;
            break;
          case 6: saturday++;
            break;
          default: break;
        }
      }
    }
  }
  var ctx = document.getElementById(id).getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar',
      // The data for our dataset
      data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
              data: [sunday, monday, tuesday, wednesday, thursday, friday, saturday],
              backgroundColor: [
                'rgb(235, 59, 90)',
                'rgb(45, 152, 218)',
                'rgba(75, 101, 132)',
                'rgba(136, 84, 208)',
                'rgba(32, 191, 107)',
                'rgb(247, 183, 49)',
                'rgb(225, 112, 85)',
              ]
          }]
      },

      // Configuration options go here
      options: {
        cutoutPercentage: 0,
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 1,
        legend: {
           display: false,
        },
      }
  });
}

function spendingMonthAnalyizer(id, jsondata) {
  var tokens = jsondata.split('][');
  for(var i = 0; i < tokens.length; i++) {
    if(i == 0)
    {
      tokens[i] = tokens[i] + "]";
    }
    else if(i == tokens.length - 1)
    {
      tokens[i] = "[" + tokens[i];
    }
    else
    {
      tokens[i] = "[" + tokens[i] + "]";
    }
    tokens[i] = JSON.parse(tokens[i]);

    var total;

    var january = 0;
    var february = 0;
    var march = 0;
    var april = 0;
    var may = 0;
    var june = 0;
    var july = 0;
    var august = 0;
    var september = 0;
    var october = 0;
    var november = 0;
    var december = 0;

    for(var j = 0; j < tokens[i].length; j++){
      if(tokens[i][j]["Headers Source"].includes("Payables")){
        var date = dateFormatChange(tokens[i][j]["Ledger Date"]);
        var dateSplit = date.split("/");
        dateSplit[2] = "20" + dateSplit[2];
        var dateFormat = new Date(dateSplit[2] + "-" + (dateSplit[1]) + "-" + dateSplit[0]);
        switch(dateFormat.getMonth()){
          case 0: january++;
            break;
          case 1: february++;
            break;
          case 2: march++;
            break;
          case 3: april++;
            break;
          case 4: may++;
            break;
          case 5: june++;
            break;
          case 6: july++;
            break;
          case 7: august++;
            break;
          case 8: september++;
            break;
          case 9: october++;
            break;
          case 10: november++;
            break;
          case 11: december++;
            break;
          default: break;
        }
      }
    }
  }
  var ctx = document.getElementById(id).getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar',
      // The data for our dataset
      data: {
          labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
          datasets: [{
              data: [january, february, march, april, may, june, july, august, september, october, november, december],
              backgroundColor: [
                'rgb(235, 59, 90)',
                'rgb(45, 152, 218)',
                'rgba(75, 101, 132)',
                'rgba(136, 84, 208)',
                'rgba(32, 191, 107)',
                'rgb(247, 183, 49)',
                'rgb(0, 206, 201)',
                'rgb(108, 92, 231)',
                'rgb(255, 234, 167)',
                'rgb(253, 121, 168)',
                'rgb(225, 112, 85)',
                'rgb(85, 239, 196)',
              ]
          }]
      },

      // Configuration options go here
      options: {
        cutoutPercentage: 0,
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 1,
        legend: {
           display: false,
        },
      }
  });
}

function spendingBusinessAnalyizer(id, jsondata) {
  var tokens = jsondata.split('][');
  var dataArray = new Array;
  var counts = {};
  for(var i = 0; i < tokens.length; i++) {
    if(i == 0)
    {
      tokens[i] = tokens[i] + "]";
    }
    else if(i == tokens.length - 1)
    {
      tokens[i] = "[" + tokens[i];
    }
    else
    {
      tokens[i] = "[" + tokens[i] + "]";
    }
    tokens[i] = JSON.parse(tokens[i]);

    for(var j = 0; j < tokens[i].length; j++){
      if(tokens[i][j]["Headers Source"].includes("Payables")){
        var transactions = tokens[i][j]["Description"].split(' | ');
        var transactions = transactions[1].split(': ');
          dataArray.push(transactions[1]);
        }
      }
    }
    dataArray.sort();
    dataArray.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
    dataArray = Object.entries(counts);
    dataArray.sort(compareFunction);

    var ctx = document.getElementById(id).getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'pie',
        // The data for our dataset
        data: {
            labels: [dataArray[0][0], dataArray[1][0], dataArray[2][0], dataArray[3][0], dataArray[4][0], dataArray[5][0]],
            datasets: [{
                data: [dataArray[0][1], dataArray[1][1], dataArray[2][1], dataArray[3][1], dataArray[4][1], dataArray[5][1]],
                backgroundColor: [
                  'rgb(235, 59, 90)',
                  'rgb(45, 152, 218)',
                  'rgba(75, 101, 132)',
                  'rgba(136, 84, 208)',
                  'rgba(32, 191, 107)',
                  'rgb(247, 183, 49)',
                  'rgb(0, 206, 201)',
                  'rgb(108, 92, 231)',
                  'rgb(255, 234, 167)',
                  'rgb(253, 121, 168)',
                  'rgb(225, 112, 85)',
                  'rgb(85, 239, 196)',
                ]
            }]
        },

        // Configuration options go here
        options: {
            responsive: false,
            //Define a new HTML Legend
            legendCallback: function(legendarray) {
                  var legendHtml = [];
      			legendHtml.push('<div class="boxxcontainer">');
                  for (var i=0; i<legendarray.data.labels.length; i++) {
                      legendHtml.push('<div id="label' + i + '" class="containerItem" style="width:100%; height: 26px;"> <div class="boxx" style="background-color:' + legendarray.data.datasets[0].backgroundColor[i] + '; border-top:#fff;"><span class="legendamt">' + legendarray.data.datasets[0].data[i] + '</span></div>');
                      if (legendarray.data.labels[i]) {
                          legendHtml.push('<div class="boxxlabel">' + "#" + (i+1) + ": " + legendarray.data.labels[i] + '</div></div>');
                      }
                  }
      			legendHtml.push('</div>');
                  return legendHtml.join("");
              },
            legend: {
      		   display: false,
      	   },
            },
      }, newlegend);
      var newlegend = document.getElementById("htmllegend").innerHTML = chart.generateLegend();
}

function spendingExpenseAnalyizer(id, jsondata) {
  var tokens = jsondata.split('][');
  var dataArray = new Array;
  var counts = {};
  for(var i = 0; i < tokens.length; i++) {
    if(i == 0)
    {
      tokens[i] = tokens[i] + "]";
    }
    else if(i == tokens.length - 1)
    {
      tokens[i] = "[" + tokens[i];
    }
    else
    {
      tokens[i] = "[" + tokens[i] + "]";
    }
    tokens[i] = JSON.parse(tokens[i]);

    for(var j = 0; j < tokens[i].length; j++){
      if(tokens[i][j]["Headers Source"].includes("Payables")){
        var transactions = tokens[i][j]["Description"].split(' | ');
        var transactions = transactions[1].split(': ');
        //transactions[1];
        //tokens[i][j]["Debit Amount"];
        var x = [transactions[1], tokens[i][j]["Debit Amount"]];
          dataArray.push(x);
        }
      }
    }
    dataArray.sort(compareFunction);
    console.log(dataArray[0][1]);
    var tStart = "<table><tr><th>#</th><th>Amount</th><th>Transaction</th></th></tr>";
    var tMiddle = "";
    for(var i = 0; i < 12; i++) {
      tMiddle += "<tr><td>" + i + "</td><td>" + moneyFormat(dataArray[i][1]) + "</td><td>" + dataArray[i][0] + "</td></tr>";
    }
    var tEnd = "</table>";
    var fullTable = tStart + tMiddle + tEnd;
    document.getElementById("topExpenses").innerHTML = fullTable;
}

function compareFunction(a,b){
  if(a[1] < b[1])
    return 1;
  else
    return -1;
}

function openGrant(id) {
  $("#content").load("includes/grants/grant.php?id=" + id);
}

function editGrant(id) {
  $("#content").load("includes/grants/edit-grant.php?id=" + id);
}

function deleteGrant(id) {
  $("#content").load("functions/delete-grant.php?id=" + id);
  closeModal();
}

function showModal(id) {
  var modal = document.getElementById('myModal');
  var modalTitle = document.getElementById('modalTitle');
  var modalContent = document.getElementById('modalContent');

  modal.style.display = "block";

  modalTitle.innerHTML = "<p><i class='fas fa-exclamation-circle'> </i> Warning!</p><span onClick='javascript:closeModal()' class='close'>&times;</span>";
  modalContent.innerHTML = "<p>Are you sure you want to delete this grant? This action cannot be undone!</p><div class='modalButtons'><button onClick='javascript:deleteGrant(" + id + ")'>Yes</button><button onClick='javascript:closeModal()'>No</button></div>";
}

function closeModal() {
  var modal = document.getElementById('myModal');
  modal.style.display = "none";
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
