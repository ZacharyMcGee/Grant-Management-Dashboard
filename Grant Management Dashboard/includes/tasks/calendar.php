<html>
  <body>
    <div id="Steele"></div>
    <script>
      var date=new Date();
      var week=date.getDay();
      var day=date.getDate();
      var year=date.getFullYear();
      var month=date.getMonth();
      var m;
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

      function leapYear(year){
      	var s=(year/4);
      	if(Math.floor(s)==s){
      		if(Math.ceil(s)==s){
      			var t=(year/100);
      			var p=(year/400);
      			if(Math.floor(t)==t){
      				if(Math.ceil(t)==t){
      					if(Math.floor(p)==p){
      						if(Math.ceil(p)==p){
      							return 1;
      						}
      						else{
      							return 0;
      						}
      					}
      					else{
      						return 0;
      					}
      				}
      				else{
      					return 0;
      				}
      			}
      			else{
      				return 1;
      			}
      		}
      		else{
      			return 0;
      		}
      	}
      	else{
      		return 0;
      	}
      }
      function createCalendar(dayone, day, m, year){
      	var a=1;
      	var tone=32;
      	var tzero=31;
      	var teight=29;
      	var tnine=30;
      	var leap=leapYear(year);
      	var tcount=0;
      	var wcount=0;
      	var wk=7;
      	var calendar;
        calendar="<table><tr><th colspan=7>";
        calendar+=m;
        calendar+=" ";
        calendar+=year;
        calendar+="</th></tr><tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr>";
        switch(dayone){
      		case 1:
      			calendar+="<tr style=text-align:center;><td></td>";
            if(day==a){
        			calendar+="<td style=background-color:yellow>";
              calendar+=a;
              calendar+="</td>";
        		}
        		else{
              calendar+="<td>";
              calendar+=a;
              calendar+="</td>";
        		}
      			a++;
      			wcount=2;
      			break;
      		case 2:
      			calendar+="<tr style=text-align:center;><td></td><td></td>";
            if(day==a){
        			calendar+="<td style=background-color:yellow>";
              calendar+=a;
              calendar+="</td>";
        		}
        		else{
              calendar+="<td>";
              calendar+=a;
              calendar+="</td>";
        		}
      			a++;
      			wcount=3;
      			break;
      		case 3:
      			calendar+="<tr style=text-align:center;><td></td><td></td><td></td>";
            if(day==a){
        			calendar+="<td style=background-color:yellow>";
              calendar+=a;
              calendar+="</td>";
        		}
        		else{
              calendar+="<td>";
              calendar+=a;
              calendar+="</td>";
        		}
      			a++;
      			wcount=4;
      			break;
      		case 4:
      			calendar+="<tr style=text-align:center;><td></td><td></td><td></td><td></td>";
            if(day==a){
        			calendar+="<td style=background-color:yellow>";
              calendar+=a;
              calendar+="</td>";
        		}
        		else{
              calendar+="<td>";
              calendar+=a;
              calendar+="</td>";
        		}
      			a++;
      			wcount=5;
      			break;
      		case 5:
      			calendar+="<tr style=text-align:center;><td></td><td></td><td></td><td></td><td></td>";
            if(day==a){
        			calendar+="<td style=background-color:yellow>";
              calendar+=a;
              calendar+="</td>";
        		}
        		else{
              calendar+="<td>";
              calendar+=a;
              calendar+="</td>";
        		}
      			a++;
      			wcount=6;
      			break;
      		case 6:
      			calendar+="<tr style=text-align:center;><td></td><td></td><td></td><td></td><td></td><td></td>";
            if(day==a){
        			calendar+="<td style=background-color:yellow>";
              calendar+=a;
              calendar+="</td>";
        		}
        		else{
              calendar+="<td>";
              calendar+=a;
              calendar+="</td>";
        		}
      			a++;
      			calendar+="</tr>";
      			break;
      		default:
      			break;
      	}
      	switch(m){
      		case 'January':
      			tcount=tone;
      			break;
      		case 'February':
      			if(leap==1){
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
      			calendar+="<tr style=text-align:center;>";
      		}
      		if(day==a){
      			calendar+="<td style=background-color:yellow>";
            calendar+=a;
            calendar+="</td>";
      		}
      		else{
            calendar+="<td>";
            calendar+=a;
            calendar+="</td>";
      		}
      		a++;
      		wcount++;
      		if(wcount>=wk){
      			calendar+="</tr>";
      			wcount=0;
      		}
      	}
        calendar+="</table>";
        return calendar;
      }
      document.getElementById('Steele').innerHTML=createCalendar(findFirstDayOfMonth(day, week), day, m, year);
    </script>
    <button onclick=>Last Month</button>
    <button onclick="">Next Month</button>
  </body>
</html>
