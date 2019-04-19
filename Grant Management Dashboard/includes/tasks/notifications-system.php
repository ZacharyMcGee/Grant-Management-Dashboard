<?php
  session_start();
  require_once '../../config.php';
  $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  if ( mysqli_connect_errno() ) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  $userId=$_SESSION['id'];
  $sql="SELECT id,deadline FROM `notifications` WHERE `userid` = '$userId'";
  $result = $con->query($sql);
  $idArray=array();
  $dlArray=array();
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $idArray[]=$row["id"];
        $dlArray[]=$row["deadline"];
      }
  }
  $count=0;
  $nameArray=array();
  $creationArray=array();
  while($count<sizeof($idArray)){
    $id=$idArray[$count];
    $sql="SELECT name,creation_date FROM `grants` WHERE `userid` = '$userId' AND `id` = '$id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $nameArray[]=$row["name"];
          $creationArray[]=$row["creation_date"];
        }
    }
    $count++;
  }
  $con->close();
?>
<html>
  <body>
<script>
function nameMonth(month){
  var m;
  switch(month){
    case 0:
      m="January";
      break;
    case 1:
      m="February";
      break;
    case 2:
      m="March";
      break;
    case 3:
      m="April";
      break;
    case 4:
      m="May";
      break;
    case 5:
      m="June";
      break;
    case 6:
      m="July";
      break;
    case 7:
      m="August";
      break;
    case 8:
      m="September";
      break;
    case 9:
      m="October";
      break;
    case 10:
      m="November";
      break;
    case 11:
      m="December";
      break;
    default:

  }
  return m;
}

function datePrefix(day){
  var prefix;
  switch(day){
    case 1:
      prefix="st";
      break;
    case 2:
      prefix="nd";
      break;
    case 3:
      prefix="rd";
      break;
    case 4:
      prefix="th";
      break;
    case 5:
      prefix="th";
      break;
    case 6:
      prefix="th";
      break;
    case 7:
      prefix="th";
      break;
    case 8:
      prefix="th";
      break;
    case 9:
      prefix="th";
      break;
    case 10:
      prefix="th";
      break;
    case 11:
      prefix="th";
      break;
    case 12:
      prefix="th";
      break;
    case 13:
      prefix="th";
      break;
    case 14:
      prefix="th";
      break;
    case 15:
      prefix="th";
      break;
    case 16:
      prefix="th";
      break;
    case 17:
      prefix="th";
      break;
    case 18:
      prefix="th";
      break;
    case 19:
      prefix="th";
      break;
    case 20:
      prefix="th";
      break;
    case 21:
      prefix="st";
      break;
    case 22:
      prefix="nd";
      break;
    case 23:
      prefix="rd";
      break;
    case 24:
      prefix="th";
      break;
    case 25:
      prefix="th";
      break;
    case 26:
      prefix="th";
      break;
    case 27:
      prefix="th";
      break;
    case 28:
      prefix="th";
      break;
    case 29:
      prefix="th";
      break;
    case 30:
      prefix="th";
      break;
    case 31:
      prefix="st";
      break;
    default:

  }
  return prefix;
}

  var deadCount=JSON.parse(<?php echo json_encode(sizeof($dlArray))?>); //pulls the size of the notification deadline array from the php
  var deadlineArray=[];
  var grantNameArray=[];
  var deadline=<?php echo json_encode($dlArray)?>; //pulls the notification deadline array from the php
  var count=0;
  var deadlineDate;
  var deadlineDateArray=[];
  var rep;
  /*sets the deadline array into the Javascript as an array of Dates*/
  while(count<deadCount){
    rep=deadline[count].replace(/-/g, ",");
    deadlineDate=new Date(rep);
    deadlineDateArray[count]=deadlineDate;
    count++;
  }
  var name=<?php echo json_encode($nameArray)?>;
  count=0;
  var grantNameArray=name.split(",");

  count=0;
  var dateBefore;
  var dateBeforeArray=[];
  var mil;
  /*sets the date back array for 4 weeks before the deadline*/
  while(count<deadCount){
    mil=deadlineDateArray[count].getTime();
    mil=(mil-2419200000);
    dateBefore=new Date(mil);
    dateBeforeArray[count]=dateBefore;
    count++;
  }

  count=0;
  var before;
  var dead;
  currdate=new Date();
  var currday=currdate.getDate();
  var currmonth=nameMonth(currdate.getMonth());
  var curryear=currdate.getFullYear();
  var date=new Date(curryear, currdate.getMonth(), currday);
  var currtime=date.getTime();
  var dateNotification=[];
  var nameNotification=[];
  var useArray=[];
  var dayte;
  //finds which of the deadlines are due in 4 weeks and puts them into an new array
  while(count<deadCount){
    dead=deadlineDateArray[count].getTime();
    before=dateBeforeArray[count].getTime();
    if(currtime>=before && currtime<=dead){
      dayte=new Date(deadlineDateArray[count]);
      dateNotification.push(dayte);
      nameNotification.push(grantNameArray[count]);
      useArray.push('0');
    }
    count++;
  }

  count=0;
  deadCount=dateNotification.length;
  orderedDateNotification=[];
  orderedNameNotification=[];
  var head=0;
  var startblock=0;
  var newCount=0;
  //puts the deadlines in order for which ones are due the soonest
  while(count<deadCount){
    startblock=0;
    head=0;
    newCount=0;
    while(newCount<deadCount){
      if(startblock===0){
        while(useArray[head]>0){
          head++;
          if(head===deadCount){
            break;
          }
        }
        if(head===deadCount){
          break;
        }
        newCount=head+1;
        while(useArray[newCount]>0){
          newCount++;
          if(newCount===deadCount){
            break;
          }
        }
        startblock++;
      }
      while(useArray[newCount]>0){
        newCount++;
        if(newCount===deadCount){
          break;
        }
      }
      if(newCount==deadCount){
        break;
      }
      if(dateNotification[newCount].getTime()<dateNotification[head].getTime()){
        head=newCount;
      }
      newCount++;
    }
    if(head===deadCount){
      break;
    }
    dayte=new Date(dateNotification[head]);
    orderedDateNotification.push(dayte);
    orderedNameNotification.push(nameNotification[head]);
    useArray[head]=1;
    count++;
  }

  count=0;
  var day;
  var month;
  var year;
  var deadlineday;
  var newday;
  notification="<table>";
  //places the deadlines into a table for printing as notifications
  while(count<deadCount){
    day=orderedDateNotification[count].getDate();
    prefix=datePrefix(day);
    month=nameMonth(orderedDateNotification[count].getMonth());
    year=orderedDateNotification[count].getFullYear();
    notification+="<tr><td>";
    notification+=orderedNameNotification[count];
    notification+="\'s annual report is due on ";
    notification+=month;
    notification+=" ";
    notification+=day;
    notification+=prefix;
    notification+=", ";
    notification+=year;
    notification+=" (";
    if(currmonth===month){
      deadlineday=(day-currday);
      switch(deadlineday){
        case 0:
          notification+="today!)";
          break;
        case 1:
          notification+=deadlineday;
          notification+=" day from now!)";
          break;
        default:
          notification+=deadlineday;
          notification+=" days from now!)";
          break;
      }
    }
    else{
      deadlineday=0;
      dead=orderedDateNotification[count].getTime();
      newday=(dead-currtime);
      while(newday>=86400000) {
        newday=(newday-86400000);
        deadlineday++;
      }
      switch(deadlineday){
        case 0:
          notification+="today!)";
          break;
        case 1:
          notification+=deadlineday;
          notification+=" day from now!)";
          break;
        default:
          notification+=deadlineday;
          notification+=" days from now!)";
          break;
      }
    }
    notification+="</td></tr>";
    count++;
  }

  var updateCount=JSON.parse(<?php echo json_encode(sizeof($creationArray))?>); //pulls the size of the creation date array
  var creation=<?php echo json_encode($creationArray)?>; //pulls the creation date array
  count=0;
  var upDate;
  var upDateArray=[];
  //creates an array of Dates with the creation dates
  while(count<updateCount){
    upDate=new Date(creation[count]);
    upDateArray[count]=upDate;
    count++;
  }

  count=0;
  var lastUpdate;
  var lastUpdateArray=[];
  //sets a date array to 31 days (1 month) after the creation date
  while(count<updateCount){
    mil=upDateArray[count].getTime();
    mil=(mil+2678400000);
    lastUpdate=new Date(mil);
    lastUpdateArray[count]=lastUpdate;
    count++;
  }

  count=0;
  var updatesLast;
  var upDateLine;
  var nameUpdate=[];
  var creationUpdate=[];
  var lastSince=[];
  var upDay;
  var hold;
  /*finds whether the current day is one month past the last time the grant had been updated.*/
  while(count<updateCount){
    upDay=0;
    updatesLast=lastUpdateArray[count].getTime();
    upDateLine=upDateArray[count].getTime();
    if(currtime>=updatesLast){
      hold=(currtime-upDateLine);
      while(hold>=86400000){
        hold=(hold-86400000);
        upDay++;
      }
      if(hold>0){
        upDay++;
      }
      dayte=new Date(upDateArray[count]);
      creationUpdate.push(dayte);
      nameUpdate.push(grantNameArray[count]);
      lastSince.push(upDay);
    }
    count++;
  }

  count=0;
  updateCount=creationUpdate.length;
  orderedCreationUpdate=[];
  orderedNameUpdate=[];
  orderedLastSince=[];
  newCount=0;
  startblock=0;
  //orders the creation dates in descending order of how long it's been since they were last updated
  while(count<updateCount){
    newCount=0;
    head=0;
    startblock=0;
    while(newCount<updateCount){
      if(startblock<1){
        while(lastSince[head]<30){
          head++;
          if(head===updateCount){
            break;
          }
        }
        if(head===updateCount){
          break;
        }
        newCount=head+1;
        while(lastSince[newCount]<30){
          newCount++;
          if(newCount===updateCount){
            break;
          }
        }
        if(newCount===updateCount){
          break;
        }
        startblock++;
      }
      while(lastSince[newCount]<30){
        newCount++;
        if(newCount===updateCount){
          break;
        }
      }
      if(newCount===updateCount){
        break;
      }
      if(lastSince[head]<lastSince[newCount]){
        head=newCount;
      }
      newCount++;
    }
    if(head===updateCount){
      break;
    }
    dayte=new Date(creationUpdate[head]);
    orderedCreationUpdate.push(dayte);
    orderedNameUpdate.push(nameUpdate[head]);
    orderedLastSince.push(lastSince[head]);
    lastSince[head]=0;
    count++;
  }

  count=0;
  //adds the update grant reminders to the notification table created
  while(count<updateCount){
    day=orderedCreationUpdate[count].getDate();
    prefix=datePrefix(day);
    month=nameMonth(orderedCreationUpdate[count].getMonth());
    year=orderedCreationUpdate[count].getFullYear();
    notification+="<tr><td>";
    notification+=orderedNameUpdate[count];
    notification+=" has not been updated since ";
    notification+=month;
    notification+=" ";
    notification+=day;
    notification+=prefix;
    notification+=", ";
    notification+=year;
    notification+=" (";
    notification+=orderedLastSince[count];
    notification+=" days ago!)";
    notification+="</td></tr>";
    count++;
  }
  notification+="</table>";

  //prints the notification table with both the deadline notifications and update grant reminders as an alert
  showAlert("alert", notification);
</script>
  </body>
</html>
