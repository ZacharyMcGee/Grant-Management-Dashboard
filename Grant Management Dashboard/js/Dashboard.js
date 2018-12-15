/* ACCORDION MENU */

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

/* EXPAND BUTTON */
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
  reader.onload = function(e) {
    var contents = e.target.result;
    loadExcel(contents);
  };
  reader.readAsBinaryString(file);
}

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

/* SIDEBAR MENU BUTTONS */

$("#new-grant").click(function(){
    $.ajax({url: "includes/grants/new-grant.php", success: function(result){
        $("#content").html(result);
        $("#breadcrumbs").html("<p>Home / New Grant</p>");
        document.getElementById('file-upload')
        .addEventListener('change', readSingleFile, false);
    }});
});

/* FUNCTIONS */
