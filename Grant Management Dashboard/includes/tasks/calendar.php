<?php
if(!isset($_SESSION)) {
	session_start();
	require_once '../../config.php';
}
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
  while($count<sizeof($idArray)){
    $id=$idArray[$count];
    $sql="SELECT name FROM `grants` WHERE `userid` = '$userId' AND `id` = '$id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $nameArray[]=$row["name"];
        }
    }
    $count++;
  }
  $con->close();
?>
<html>
<body>
  <div id="Steele"></div>
  <script>
    var deadCount=JSON.parse(<?php echo json_encode(sizeof($dlArray))?>);
    var deadlineArray=[];
    var deadline=<?php echo json_encode($dlArray)?>;
    var count=0;
    while(count<deadCount){
      deadlineArray[count]=deadline[count];
      count++;
    }
    var name=<?php echo json_encode($nameArray)?>;
    var grantsNameArray=name.split(",");
    count=0;
    var rep;
    while(count<deadCount){
      rep=deadlineArray[count].replace(/-/g, ",");
      deadlineArray[count]=rep;
      count++;
    }
    count=0;
    var deadlineDay;
    var deadlineDayArray=[];
    while(count<deadCount){
      deadlineDay=new Date(deadlineArray[count]);
      deadlineDayArray[count]=deadlineDay;
      count++;
    }
    var date=new Date();
    var week=date.getDay();
    var day=date.getDate();
    var year=date.getFullYear();
    var month=date.getMonth();

    /*this makes it to where only upcoming deadlines are visible. If you want all deadlines visible, just put
    this whole block into comments and set the grant name array to grantsNameArray and set the deadline array
    to deadlineDayArray in the Create Calendar functions.*/
    count=0;
    var datesplus=new Date(year, month, day);
    var deadlineDate;
    var datesCull=datesplus.getTime();
    var deadlinesCull;
    var deadlineDateArray=[];
    var grantNameArray=[];
    while(count<deadCount){
      deadlinesCull=deadlineDayArray[count].getTime();
      if(datesCull<=deadlinesCull){
        deadlineDate=new Date(deadlineDayArray[count]);
        deadlineDateArray.push(deadlineDate);
        grantNameArray.push(grantsNameArray[count]);
      }
      count++;
    }

    var t=month;
    var u=year;
    var m;
    /*returns the name of the month. input is the integer returned from the getMonth() function.*/
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
    m=nameMonth(month);

    /*finds the first day of the month. returns the numerical representation for the day of the week (0-6). inputs
    should be the results of getDate() and getDay().*/
    function findFirstDayOfMonth(day, week){
      var wnum=week;
      var dnum=day;
      while(dnum > 7){
        dnum=dnum-7;
      }
      while(dnum != 1){
        dnum--;
        if(wnum==0){
          wnum=6;
        }
        else{
          wnum--;
        }
      }
      return wnum;
    }

    //taken from moments.js
    function isLeapYear(year) {
        return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
    }

    /*creates a table containing that month's calendar, inputs are the result of the findFirstDayOfMonth() function,
    getDate(), result of nameMonth(), and getFullYear(). highlights current day.*/
    function createCalendar(dayone, day, m, year, deadlineDateArray, grantNameArray){
      var a=1;
      var tone=32;
      var tzero=31;
      var teight=29;
      var tnine=30;
      var leap=isLeapYear(year);
      var tcount=0;
      var wcount=0;
      var wk=7;
      var deadMonth;
      var deadYear;
      var deadM;
      var deadDay;
      var deadlineCounter=0;
      var currentDayCounter=0;
      var regCount=0;
      var deadCount=deadlineDateArray.length;
      var calendar;
      calendar="<table class=\"calendar-table\"><tr><th class=\"calendar-month\" colspan=7> <button class=\"left-calendar-button\" id=\"next-last-month\" onclick=\"document.getElementById('Steele').innerHTML=printLastMonthCalendar(t--, u, deadlineDateArray, grantNameArray);\">\< Last Month</button>";
      calendar+=m;
      calendar+=" ";
      calendar+=year;
      calendar+="<button class=\"right-calendar-button\" id=\"next-last-month\" onclick=\"document.getElementById('Steele').innerHTML=printNextMonthCalendar(t++, u, deadlineDateArray, grantNameArray);\">Next Month \></button></th></tr><tr><th class=\"calendar-head\">Sunday</th><th class=\"calendar-head\">Monday</th><th class=\"calendar-head\">Tuesday</th><th class=\"calendar-head\">Wednesday</th><th class=\"calendar-head\">Thursday</th><th class=\"calendar-head\">Friday</th><th class=\"calendar-head\">Saturday</th></tr>";
      switch(dayone){
        case 1:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td>";
          currentDayCounter=0;
          deadlineCounter=0;
          regCount=0;
          if(a==day){
            currentDayCounter++;
          }
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(currentDayCounter==0 && deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(currentDayCounter==1 && deadlineCounter==0){
                calendar+="<td class=\"calendar-current-day-deadline\"><span class=\"current-deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(currentDayCounter>0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-current-day\"><span class=\"current-data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else if(currentDayCounter==0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=2;
          break;
        case 2:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          currentDayCounter=0;
          deadlineCounter=0;
          regCount=0;
          if(a==day){
            currentDayCounter++;
          }
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(currentDayCounter==0 && deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(currentDayCounter==1 && deadlineCounter==0){
                calendar+="<td class=\"calendar-current-day-deadline\"><span class=\"current-deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(currentDayCounter>0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-current-day\"><span class=\"current-data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else if(currentDayCounter==0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=3;
          break;
        case 3:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          currentDayCounter=0;
          deadlineCounter=0;
          regCount=0;
          if(a==day){
            currentDayCounter++;
          }
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(currentDayCounter==0 && deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(currentDayCounter==1 && deadlineCounter==0){
                calendar+="<td class=\"calendar-current-day-deadline\"><span class=\"current-deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(currentDayCounter>0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-current-day\"><span class=\"current-data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else if(currentDayCounter==0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=5;
          break;
        case 5:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          currentDayCounter=0;
          deadlineCounter=0;
          regCount=0;
          if(a==day){
            currentDayCounter++;
          }
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(currentDayCounter==0 && deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(currentDayCounter==1 && deadlineCounter==0){
                calendar+="<td class=\"calendar-current-day-deadline\"><span class=\"current-deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(currentDayCounter>0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-current-day\"><span class=\"current-data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else if(currentDayCounter==0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=6;
          break;
        case 6:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          currentDayCounter=0;
          deadlineCounter=0;
          regCount=0;
          if(a==day){
            currentDayCounter++;
          }
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(currentDayCounter==0 && deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(currentDayCounter==1 && deadlineCounter==0){
                calendar+="<td class=\"calendar-current-day-deadline\"><span class=\"current-deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(currentDayCounter>0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-current-day\"><span class=\"current-data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else if(currentDayCounter==0 && deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          calendar+="</tr>";
          break;
        default:

      }
      switch(m){
        case 'January':
          tcount=tone;
          break;
        case 'February':
          if(leap==true){
            tcount=tnine;
          }
          else{
            tcount=teight;
          }
          break;
        case 'March':
          tcount=tone;
          break;
        case 'April':
          tcount=tzero;
          break;
        case 'May':
          tcount=tone;
          break;
        case 'June':
          tcount=tzero;
          break;
        case 'July':
          tcount=tone;
          break;
        case 'August':
          tcount=tone;
          break;
        case 'September':
          tcount=tzero;
          break;
        case 'October':
          tcount=tone;
          break;
        case 'November':
          tcount=tzero;
          break;
        case 'December':
          tcount=tone;
          break;
        default:

      }
      while(a<tcount){
        if(wcount==0){
          calendar+="<tr class=\"calendar-week\">";
        }
        currentDayCounter=0;
        deadlineCounter=0;
        regCount=0;
        if(a==day){
          currentDayCounter++;
        }
        while(regCount<deadCount){
          deadMonth=deadlineDateArray[regCount].getMonth();
          deadYear=deadlineDateArray[regCount].getFullYear();
          deadDay=deadlineDateArray[regCount].getDate();
          deadM=nameMonth(deadMonth);
          if(deadM==m && deadYear==year && deadDay==a){
            if(currentDayCounter==0 && deadlineCounter==0){
              calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
              calendar+=a;
              calendar+="</span>";
              calendar+=grantNameArray[regCount];
              calendar+=" is due";
              deadlineCounter++;
            }
            else if(currentDayCounter==1 && deadlineCounter==0){
              calendar+="<td class=\"calendar-current-day-deadline\"><span class=\"current-deadline-data-text\">";
              calendar+=a;
              calendar+="</span>";
              calendar+=grantNameArray[regCount];
              calendar+=" is due";
              deadlineCounter++;
            }
            else if(deadlineCounter>0){
              calendar+=" ";
              calendar+=grantNameArray[regCount];
              calendar+=" is due";
            }
          }
          regCount++;
        }
        if(currentDayCounter>0 && deadlineCounter==0){
          calendar+="<td class=\"calendar-current-day\"><span class=\"current-data-text\">";
          calendar+=a;
          calendar+="</span></td>";
        }
        else if(currentDayCounter==0 && deadlineCounter==0){
          calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
          calendar+=a;
          calendar+="</span></td>";
        }
        else{
          calendar+="</td>";
        }
        a++;
        wcount++;
        if(wcount>=wk){
          calendar+="</tr>";
          wcount=0;
        }
      }
      switch(wcount){
        case 1:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 2:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 3:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 4:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 5:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 6:
          calendar+="<td class=\"calendar-data\"></td></tr>";
          break;
        default:

      }
      calendar+="</table>";
      return calendar;
    }

    //prints the calendar to the Steele div
    document.getElementById('Steele').innerHTML=createCalendar(findFirstDayOfMonth(day, week), day, m, year, deadlineDateArray, grantNameArray);

    /*creates a table containing that month's calendar, inputs are the result of the findFirstDayOfMonth() function,
    result of nameMonth(), and getFullYear(). only difference from createCalendar() is that it doesn't highlight the
    current day.*/
    function createNotCurrentCalendar(dayone, m, year, deadlineDateArray, grantNameArray){
      var a=1;
      var tone=32;
      var tzero=31;
      var teight=29;
      var tnine=30;
      var leap=isLeapYear(year);
      var tcount=0;
      var wcount=0;
      var wk=7;
      var deadMonth;
      var deadYear;
      var deadM;
      var deadDay;
      var deadlineCounter=0;
      var regCount=0;
      var deadCount=deadlineDateArray.length;
      var calendar;
      calendar="<table class=\"calendar-table\"><tr><th class=\"calendar-month\" colspan=7> <button class=\"left-calendar-button\" id=\"next-last-month\" onclick=\"document.getElementById('Steele').innerHTML=printLastMonthCalendar(t--, u, deadlineDateArray, grantNameArray);\">\< Last Month</button>";
      calendar+=m;
      calendar+=" ";
      calendar+=year;
      calendar+="<button class=\"right-calendar-button\" id=\"next-last-month\" onclick=\"document.getElementById('Steele').innerHTML=printNextMonthCalendar(t++, u, deadlineDateArray, grantNameArray);\">Next Month \></button></th></tr><tr><th class=\"calendar-head\">Sunday</th><th class=\"calendar-head\">Monday</th><th class=\"calendar-head\">Tuesday</th><th class=\"calendar-head\">Wednesday</th><th class=\"calendar-head\">Thursday</th><th class=\"calendar-head\">Friday</th><th class=\"calendar-head\">Saturday</th></tr>";
      switch(dayone){
        case 1:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td>";
          deadlineCounter=0;
          regCount=0;
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=2;
          break;
        case 2:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          deadlineCounter=0;
          regCount=0;
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=3;
          break;
        case 3:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          deadlineCounter=0;
          regCount=0;
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=4;
          break;
        case 4:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          deadlineCounter=0;
          regCount=0;
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=5;
          break;
        case 5:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          deadlineCounter=0;
          regCount=0;
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          wcount=6;
          break;
        case 6:
          calendar+="<tr class=\"calendar-week\"><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td>";
          deadlineCounter=0;
          regCount=0;
          while(regCount<deadCount){
            deadMonth=deadlineDateArray[regCount].getMonth();
            deadYear=deadlineDateArray[regCount].getFullYear();
            deadDay=deadlineDateArray[regCount].getDate();
            deadM=nameMonth(deadMonth);
            if(deadM==m && deadYear==year && deadDay==a){
              if(deadlineCounter==0){
                calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
                calendar+=a;
                calendar+="</span>";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
                deadlineCounter++;
              }
              else if(deadlineCounter>0){
                calendar+=" ";
                calendar+=grantNameArray[regCount];
                calendar+=" is due";
              }
            }
            regCount++;
          }
          if(deadlineCounter==0){
            calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
            calendar+=a;
            calendar+="</span></td>";
          }
          else{
            calendar+="</td>";
          }
          a++;
          calendar+="</tr>";
          break;
        default:

      }
      switch(m){
        case 'January':
          tcount=tone;
          break;
        case 'February':
          if(leap==true){
            tcount=tnine;
            break;
          }
          else{
            tcount=teight;
            break;
          }
        case 'March':
          tcount=tone;
          break;
        case 'April':
          tcount=tzero;
          break;
        case 'May':
          tcount=tone;
          break;
        case 'June':
          tcount=tzero;
          break;
        case 'July':
          tcount=tone;
          break;
        case 'August':
          tcount=tone;
          break;
        case 'September':
          tcount=tzero;
          break;
        case 'October':
          tcount=tone;
          break;
        case 'November':
          tcount=tzero;
          break;
        case 'December':
          tcount=tone;
          break;
        default:

      }
      while(a<tcount){
        if(wcount==0){
          calendar+="<tr class=\"calendar-week\">";
        }
        deadlineCounter=0;
        regCount=0;
        while(regCount<deadCount){
          deadMonth=deadlineDateArray[regCount].getMonth();
          deadYear=deadlineDateArray[regCount].getFullYear();
          deadDay=deadlineDateArray[regCount].getDate();
          deadM=nameMonth(deadMonth);
          if(deadM==m && deadYear==year && deadDay==a){
            if(deadlineCounter==0){
              calendar+="<td class=\"calendar-deadline\"><span class=\"deadline-data-text\">";
              calendar+=a;
              calendar+="</span>";
              calendar+=grantNameArray[regCount];
              calendar+=" is due";
              deadlineCounter++;
            }
            else if(deadlineCounter>0){
              calendar+=" ";
              calendar+=grantNameArray[regCount];
              calendar+=" is due";
            }
          }
          regCount++;
        }
        if(deadlineCounter==0){
          calendar+="<td class=\"calendar-data\"><span class=\"data-text\">";
          calendar+=a;
          calendar+="</span></td>";
        }
        else{
          calendar+="</td>";
        }
        a++;
        wcount++;
        if(wcount>=wk){
          calendar+="</tr>";
          wcount=0;
        }
      }
      switch(wcount){
        case 1:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 2:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 3:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 4:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 5:
          calendar+="<td class=\"calendar-data\"></td><td class=\"calendar-data\"></td></tr>";
          break;
        case 6:
          calendar+="<td class=\"calendar-data\"></td></tr>";
          break;
        default:

      }
      calendar+="</table>";
      return calendar;
    }

    /*prints the calendar for the next month. inputs needed are the month and year*/
    function printNextMonthCalendar(month, year, deadlineDateArray, grantNameArray){
      month=month+1;
      var nxtdate;
      if(month==12){
        month=0;
        year++;
        nxtdate=new Date(year, month, 12);
      }
      else{
        nxtdate=new Date(year, month, 12);
      }
      var curdate=new Date();
      var curweek=curdate.getDay();
      var curday=curdate.getDate();
      var curyear=curdate.getFullYear();
      var curmonth=curdate.getMonth();
      var nxtmonth=nxtdate.getMonth();
      var nxtyear=nxtdate.getFullYear();
      var nxtday=nxtdate.getDate();
      var nxtweek=nxtdate.getDay();
      if(curmonth==nxtmonth && curyear==nxtyear){
        var curdayone=findFirstDayOfMonth(curday, curweek);
        var curm=nameMonth(curmonth);
        return createCalendar(curdayone, curday, curm, curyear, deadlineDateArray, grantNameArray);
      }
      else{
        var nxtdayone=findFirstDayOfMonth(nxtday, nxtweek);
        var m=nameMonth(nxtmonth);
        return createNotCurrentCalendar(nxtdayone, m, nxtyear, deadlineDateArray, grantNameArray);
      }
    }

    function printLastMonthCalendar(month, year, deadlineDateArray, grantNameArray){
      month=month-1;
      var lstdate;
      if(month==-1){
        month=11;
        year--;
        lstdate=new Date(year, month, 12);
      }
      else{
        lstdate=new Date(year, month, 12);
      }
      var curdate=new Date();
      var curweek=curdate.getDay();
      var curday=curdate.getDate();
      var curyear=curdate.getFullYear();
      var curmonth=curdate.getMonth();
      var lstmonth=lstdate.getMonth();
      var lstyear=lstdate.getFullYear();
      var lstday=lstdate.getDate();
      var lstweek=lstdate.getDay();
      if(curmonth==lstmonth && curyear==lstyear){
        var curdayone=findFirstDayOfMonth(curday, curweek);
        var curm=nameMonth(curmonth);
        return createCalendar(curdayone, curday, curm, curyear, deadlineDateArray, grantNameArray);
      }
      else{
        var lstdayone=findFirstDayOfMonth(lstday, lstweek);
        var m=nameMonth(lstmonth);
        return createNotCurrentCalendar(lstdayone, m, lstyear, deadlineDateArray, grantNameArray);
      }
    }
  </script>
</body>
</html>
