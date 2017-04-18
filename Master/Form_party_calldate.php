<html>
<head>
<title>Entry Form for party_calldate</title>
</head>
<script language=javascript>
<!--
function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Code.value=mvalue;

var a=myform.Code.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="Form_party_calldate.php?tag=2&ptype=0";
myform.submit();
}
}

function direct1()
{
var i;
i=0;
}

function setMe()
{
myform.Code.focus();
}

function redirect(i)
{
}

function validate()
{
//var j1=myform.rollno.selectedIndex;//Returns Numeric Index from 0
//var j2=myform.box1.checked;//Return true if check box is checked
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="../Mainmenu.php?tag=1";
var a=myform.Code.value ;// Primary Key
var b=myform.Mydate.value ;
var b_length=parseInt(b.length);
var c=myform.Polldate.value ;
var c_length=parseInt(c.length);
var d=myform.Mydate1.value ;
var d_length=parseInt(d.length);
var f=myform.Assemble_place.value ;
var f_length=parseInt(f.length);
var g=myform.Poll_starttime.value ;
var g_length=parseInt(g.length);
var h=myform.Poll_endtime.value ;
var h_length=parseInt(h.length);
var i=myform.Mplace.value ;
var i_length=parseInt(i.length);
var j=myform.Mdate.value ;
var j_length=parseInt(j.length);
var k=myform.Msignature.value ;
var k_length=parseInt(k.length);
if ( isNumber(a)==true   && 1==1 && validateString(b) && b_length<=10 && 1==1 && validateString(c) && c_length<=10 && 1==1 && validateString(d) && d_length<=10 && 1==1 && validateString(f) && f_length<=100 && 1==1 && validateString(g) && g_length<=20 && 1==1 && validateString(h) && h_length<=20 && 1==1 && validateString(i) && i_length<=50 && 1==1 && validateString(j) && j_length<=20 && 1==1 && validateString(k) && k_length<=150)
{
myform.action="Insert_party_calldate.php";
myform.submit();
}
else
alert('Invalid Data');
}



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
}

function home()
{
window.location="../Mainmenu.php?tag=1";
}



//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}

//change color on focus to Box(a)
function ChangeColor(el,i)
{
if (i==1) // on focus
document.getElementById(el).style.backgroundColor = '#99CC33';
if (i==2) //on lostfocus
{
document.getElementById(el).style.backgroundColor = 'white';
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

if(str_index==-1 && str_select==-1 && str_insert==-1 && str_delete==-1 && str_dash==-1 && str_vbscript==-1 && str_javascript==-1 && str_ampersond==-1 && str_semicolon==-1)
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

function LoadTextBox()
{
var i=myform.Editme.selectedIndex;
if(i>0)
myform.edit1.disabled=false;
else
myform.edit1.disabled=true;
//alert('Write Java Script as per requirement');
}
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

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.party_calldate.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objParty_calldate=new Party_calldate();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

$lock=" ";

if ($_tag>2)
$_tag=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if (!is_numeric($mtype))
$mtype=0;

$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[10]=0;
$mvalue[0]=$objParty_calldate->MaxCode();
}
else
{
$mvalue[0]="-1";//Code
$mvalue[1]="";//Mydate
$mvalue[2]="";//Polldate
$mvalue[3]="";//Mydate1
$mvalue[4]="";//Assemble_place
$mvalue[5]="";//Poll_starttime
$mvalue[6]="";//Poll_endtime
$mvalue[7]="";//Mplace
$mvalue[8]="";//Mdate
$mvalue[9]="";//Msignature
$mvalue[10]=0;
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
}//tag=1 [Return from Action form]

if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objParty_calldate->MaxCode() Function Here if required and Load in $mvalue[0]
$mvalue[0]=$objParty_calldate->MaxCode();
$mvalue[1]="";//Mydate
$mvalue[2]="";//Polldate
$mvalue[3]="";//Mydate1
$mvalue[4]="";//Assemble_place
$mvalue[5]="";//Poll_starttime
$mvalue[6]="";//Poll_endtime
$mvalue[7]="";//Mplace
$mvalue[8]="";//Mdate
$mvalue[9]="";//Msignature
$mvalue[10]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Code']))
$pkarray[0]=$_POST['Code'];
else
$pkarray[0]=0;
$objParty_calldate->setCode($pkarray[0]);
if ($objParty_calldate->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objParty_calldate->getCode();
$mvalue[1]=$objParty_calldate->getMydate();
$mvalue[2]=$objParty_calldate->getPolldate();
$mvalue[3]=$objParty_calldate->getMydate1();
$mvalue[4]=$objParty_calldate->getAssemble_place();
$mvalue[5]=$objParty_calldate->getPoll_starttime();
$mvalue[6]=$objParty_calldate->getPoll_endtime();
$mvalue[7]=$objParty_calldate->getMplace();
$mvalue[8]=$objParty_calldate->getMdate();
$mvalue[9]=$objParty_calldate->getMsignature();
$mvalue[10]=0;//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
$lock=" readonly";
} 
else //data not available for edit
{
$_SESSION['update']=0;
$lock=" ";
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]="";
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]="";
$mvalue[5]="";
$mvalue[6]="";
$mvalue[7]="";
$mvalue[8]="";
$mvalue[9]="";
$mvalue[10]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<form name=myform action=insert_party_calldate.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Form for Party Call Detail<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Code</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=8 name="Code" id="Code" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Code',1)"  onblur="ChangeColor('Code',2)" onchange=direct1() <?php echo $lock;?>>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Reporting Date</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=10 name="Mydate" id="Mydate" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Mydate',1)"  onblur="ChangeColor('Mydate',2)">
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Poll Date</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=10 name="Polldate" id="Polldate" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Polldate',1)"  onblur="ChangeColor('Polldate',2)">
</td>
</tr>
<?php $i++; //Now i=3?>
<input type=hidden size=10 name="Mydate1" id="Mydate1" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Mydate1',1)"  onblur="ChangeColor('Mydate1',2)">
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Assemble Place</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=50 name="Assemble_place" id="Assemble_place" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=100 onfocus="ChangeColor('Assemble_place',1)"  onblur="ChangeColor('Assemble_place',2)">
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Poll Start Time</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=20 name="Poll_starttime" id="Poll_starttime" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Poll_starttime',1)"  onblur="ChangeColor('Poll_starttime',2)">
</td>
</tr>
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Poll End Time</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=20 name="Poll_endtime" id="Poll_endtime" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Poll_endtime',1)"  onblur="ChangeColor('Poll_endtime',2)">
</td>
</tr>
<?php $i++; //Now i=7?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Place of Sign</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=50 name="Mplace" id="Mplace" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Mplace',1)"  onblur="ChangeColor('Mplace',2)">
</td>
</tr>
<?php $i++; //Now i=8?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Date of Sign</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=20 name="Mdate" id="Mdate" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Mdate',1)"  onblur="ChangeColor('Mdate',2)">
</td>
</tr>
<?php $i++; //Now i=9?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Signature Detail</font></td><td align=left bgcolor=#FFFFCC>
<input type=text size=80 name="Msignature" id="Msignature" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=150 onfocus="ChangeColor('Msignature',1)"  onblur="ChangeColor('Msignature',2)">
</td>
</tr>
<?php $i++; //Now i=10?>
<tr><td align=right bgcolor=#FFFFCC>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td><td align=left bgcolor=#FFFFCC>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
<input type=button value=Menu  name=back1 onclick=home() onfocus="ChangeFocus('Code')" style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
</td></tr>
<tr><td align=right>
<?php 
$objParty_calldate->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objParty_calldate->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:120px" onchange=LoadTextBox()>
<?php $dval="-1";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{?>
<option  value="<?php echo $row[$ind][0];?>"><?php echo $row[$ind][1];

} //for loop
?>
</select>
</td><td align=left>
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Code");

?>
</body>
</html>
