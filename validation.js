//Common Java Script

function isdate(dt,tag)
{
//var dt=myform.Est_On.value;
var ln=parseInt(dt.length);
var dd;
var mm;
var yyyy;
var leapday;
var tt=true;
var i=dt.indexOf("/");
dd=dt.substr(0,i);
var j=dt.indexOf("/",(i+1));
mm=dt.substr((i+1),(j-i-1));
yyyy=dt.substr((j+1),(ln-j-1));
if(isNaN(yyyy)==false)
{
var t=parseInt(yyyy%4);
if(t==0)
leapday=29;
else
leapday=28;
}
if((tag==0) && ln==0)  //for null field No check
tt=true;
else
{
if (isNaN(dd)==false && isNaN(mm)==false && isNaN(yyyy)==false)
{
dd=Number(dd);
mm=Number(mm);
yyyy=Number(yyyy);
if( (mm>0) && (mm<13) && (dd>0) && (dd<32))
{
if((mm==4)||(mm==6)||(mm==9)||(mm==11)) //30st day
{
if (dd>30)
{
alert('Invalid Date '+dt+'(DD Part out of range)');
tt=false;
}
} // mm==4
if (mm==2)
{
if (dd>leapday)
{
alert('Invalid Date '+dt+'(DD Part)');
tt=false;
}
} //mm==2
}
else //mm>0 && dd>0
{
alert('Invalid Date '+dt+'(Month out of range)');
tt=false;
}
}
else  // Non numeric figure appears
{
alert('Invalid date '+dt);
tt=false;
}
}// not null
return(tt);
} //End date validation


//date comaprison
function CompareDate(dt1,dt2)
{
var ln;
var i;
var j;
var dd1;
var mm1;
var yyyy1;

var dd2;
var mm2;
var yyyy2;
var tag;
var date1;
var date2;

ln=parseInt(dt1.length);
i=dt1.indexOf("/");
dd1=Number(dt1.substr(0,i));
j=dt1.indexOf("/",(i+1));
mm1=Number(dt1.substr((i+1),(j-i-1)));
yyyy1=Number(dt1.substr((j+1),(ln-j-1)));

dd1= dd1+100;
mm1= mm1+100;

date1=yyyy1+"-"+mm1+"-"+dd1;

ln=parseInt(dt2.length);
i=dt2.indexOf("/");
dd2=Number(dt2.substr(0,i));
j=dt2.indexOf("/",(i+1));
mm2=Number(dt2.substr((i+1),(j-i-1)));
yyyy2=Number(dt2.substr((j+1),(ln-j-1)));

dd2= dd2+100;
mm2= mm2+100;

date2=yyyy2+"-"+mm2+"-"+dd2;

if (date1>date2)
return(1);
if (date1==date2) 
return(0);
if (date1<date2)
return(-1);
}//End date Comparison


//change color on focus to Box(a)
function ChangeColor(el,i)
{
if (i==1) // on focus
{
document.getElementById(el).style.backgroundColor = '#99CC33';
document.getElementById(el).style.fontWeight = 'bold';
}
if (i==2) //on lostfocus
{
document.getElementById(el).style.backgroundColor = 'white';
document.getElementById(el).style.fontWeight = 'normal';
var temp=document.getElementById(el).value;
trimBlank(temp,el);
}
}//changeColor on Focus


function validateString(str)
{
var str_index=str.indexOf("'");
var str_select=str.indexOf("select");
var str_insert=str.indexOf("insert");
var str_delete=str.indexOf("delete");
var str_dash=str.indexOf("--");
var str_vbscript=str.indexOf("vbscript");
var str_javascript=str.indexOf("javascript");
var str_ampersond=str.indexOf("&");
var str_lessthan=str.indexOf("<");
var str_greaterthan=str.indexOf(">");
var str_semicolon=str.indexOf(";");

if(str_index==-1 && str_select==-1 && str_insert==-1 && str_delete==-1 && str_dash==-1 && str_vbscript==-1 && str_javascript==-1 && str_ampersond==-1 && str_lessthan==-1 && str_greaterthan==-1 && str_semicolon==-1)
return(true);
else
return(false);
} 

function notNull(str)
{
var k=0;
var found=false;
var mylength=str.length;
for (var i = 0; i < str.length; i++) 
{  
k=parseInt(str.charCodeAt(i)); 
if (k!=32)
found=true;
}
return(found);
}



function isNumber(ad)
{
if (isNaN(ad)==false && notNull(ad))
return(true);
else
return(false);
}



function checkName(str)
{
//var  str=n.value;
var k=0;
var found=true;
var mylength=str.length;
var newstr="";
for (var i = 0; i < str.length; i++) 
{  
k=parseInt(str.charCodeAt(i)); 
//Allow Alphabet and Blank
if ( (k>=97 && k<=122)  || (k>=65 && k<=90) || (k==32)  )
{
newstr=newstr+str.substr(i,1);
}
else
{
alert('Invalid Character String ['+str+']');
found=false;
i=mylength+1;
}
}
return(found);
}

function RemoveSpace(a)
{
var newstr="";
var str=document.getElementById(a).value;
for (var i = 0; i < str.length; i++)
{
k=parseInt(str.charCodeAt(i));
if (k==32)
newstr=newstr;
else
newstr=newstr+str.substr(i,1);
} //for loop
document.getElementById(a).value=newstr;
}//trimBlank


function trimBlank(str,a)
{

var newstr="";
var prev=0;
for (var i = 0; i < str.length; i++)
{
k=parseInt(str.charCodeAt(i));
if (k==32 && prev==0)
{
newstr=newstr;
}
else
{
newstr=newstr+str.substr(i,1);
}
if (k==32)
prev=0;
else
prev=1;
}
document.getElementById(a).value=newstr;
}//trimBlank


function nonZero(ad)
{
if (isNumber(ad))
{
if (parseInt(ad)>0)
return(true);
else
return(false);
} 
else
return(false);
}

function checkMobile(b,tag)
{

var found;
var str1;
var str2;
var dash;
found=false;

var str=document.getElementById(b).value;
var mylength=str.length;
//alert(str);
//alert(mylength);
if(tag==0 && mylength==0)
found=true;
else
{
if (mylength==10 )
{    
str1=str.substr(0,5);
str2=str.substr(5,5);
if(isNumber(str1) && isNumber(str2) )
{
str=str1+'-'+str2;
document.getElementById(b).value=str;
found=true;
}
} //mylength=10
if (mylength==11)
{    
str1=str.substr(0,5);
str2=str.substr(6,5);
dash=str.substr(5,1)
if(isNumber(str1) && isNumber(str2) && isNumber(dash)==false )
{
str=str1+'-'+str2;
document.getElementById(b).value=str;
found=true;
}
} //mylength=11
} //tag==0 && mylength==0

return(found);
}




function StringValid(a,tag)
{
var ok=false;
var b=document.getElementById(a).value;
if(tag==1) //donot allow null
{
if(SimpleValidate(b) && notNull(b))
ok=true;
}//tag==1
if(tag==0) //allow null
{
if(SimpleValidate(b))
ok=true;
}//tag==0
//if(ok==false)
//{
//alert('Invalid Data');
//document.getElementById(a).focus();
//}//ok=false
return(ok);
}//StringValid


function DateValid(a,tag)
{
var ok=false;
var b=document.getElementById(a).value;
if(tag==1) //donot allow null
{
if(isdate(b,1))
ok=true;
}//tag==1
if(tag==0) //allow null
{
if(isdate(b,0))
ok=true;
}//tag==0
return(ok);
}//DateValid

function NumericValid(a,tag)
{
var ok=true;
var b=document.getElementById(a).value;
if(isNumber(b)==false)
{
var ok=false;
//alert('Invalid Value');
document.getElementById(a).focus();
}
return(ok);
}//NumericValid

function SelectBoxIndex(a)
{
var b=document.getElementById(a).selectedIndex;
return(b);
}//SelectionValidate

function SimpleValidate(str)
{
var str_index=str.indexOf("'");
var str_dash=str.indexOf("--");
var str_semicolon=str.indexOf(";");

if(str_index==-1 && str_dash==-1 && str_semicolon==-1)
return(true);
else
return(false);
} 




function MyAjaxFunction(method,URL,data,Obj,Type)
{
var ajaxRequest;  // The variable that makes Ajax possible!
try
{
// Opera 8.0+, Firefox, Safari
ajaxRequest = new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer Browsers
try
{
ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
}catch (e)
{
try{
ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
}catch (e)
{
// Something went wrong
alert("Your browser broke!");
return false;
}
}
}

ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById(Obj);
  if(Type=="TEXT")
    ajaxDisplay.value=ajaxRequest.responseText;
    if(Type=="HTML")
  ajaxDisplay.innerHTML = ajaxRequest.responseText;    
if(Type=="MSGHTML" || Type=="MSGTEXT")
{
var temp=ajaxRequest.responseText;
var mylength=parseInt(temp.length);
var ind=temp.indexOf("&",0); // Search Position index of  &
var msg=temp.substr(0, ind);// Separate Message Part
var tvalue=temp.substr(ind+1,mylength-ind);
if(Type=="MSGHTML")
ajaxDisplay.innerHTML = tvalue; 
if(Type=="MSGTEXT")
ajaxDisplay.value= tvalue; 
alert(msg);
}//Type=="MSGHTML" || Type="MSGTEXT"
} //readydyState == 4)
} //end function
 if(method=="GET")
 {
 ajaxRequest.open("GET", URL +"?"+data, true);
 ajaxRequest.send(null); 
 }
 if(method=="POST")
 {
 ajaxRequest.open("POST", URL, true);
 ajaxRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 ajaxRequest.send(data);
}
}//end my AJAX function


function ParseXmlString(xmlString,Tag_id,nodeIndex,inputBox_id)
{
if (window.DOMParser)
  {
  parser=new DOMParser();
  xmlDoc=parser.parseFromString(xmlString,"text/xml");
}
else // Internet Explorer
  {
  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  xmlDoc.async=false;
  xmlDoc.loadXML(xmlString);
  }
var mval=xmlDoc.getElementsByTagName(Tag_id)[nodeIndex].childNodes[0].nodeValue;
document.getElementById(inputBox_id).value=mval;
} //end ParseXML String

