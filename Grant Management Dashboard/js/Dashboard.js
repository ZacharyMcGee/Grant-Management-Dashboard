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

$("#calendar").click(function(){
    $.ajax({url: "includes/tasks/calendar.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p><a href='dashboard.php'><i class='fas fa-home'></i></a> / Schedule Alert</p>");
    }});
});

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
  console.log("json = " + jsondata);
  jsondata = jsondata.substring(1, jsondata.length-1);
  jsondata = JSON.parse(jsondata);
  console.log(award + " and ");
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
