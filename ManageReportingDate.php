
<?php
include("Menuhead.html");
?>
<script type=text/javascript src="validation.js"></script>
<script language=javascript>
<!--

function proceed()
{
var fname="uploadimage.php";
window.open(fname,'_self');
}

function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Code.value=mvalue;

var a=myform.Code.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="ManageReportingDate.php?tag=2&ptype=0";
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
//var a=myform.Code.value ;// Primary Key

var c=myform.Polldate.value ;
var c_length=parseInt(c.length);
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

var pdate=myform.Pdate.value;

if (isdate(c,1) && isdate(j,1) && validateString(c) && c_length<=10 &&  validateString(f) && f_length<=100  && validateString(g) && g_length<=20  && validateString(h) && h_length<=20  && validateString(i) && i_length<=50 && validateString(j) && j_length<=20 && SimpleValidate(k) && k_length<=150)
{
if(CompareDate(c,pdate)==-1)
alert('Invalid Poll Date');
else if (CompareDate(j,pdate)==-1)
alert('Invalid Letter Date');
else
{
myform.action="Insert_party_calldate.php";
myform.submit();
}
}//if (isdate(c,1)
else
alert('Invalid Data');
}


function home()
{
window.location="mainmenu.php?tag=1";
}


//END JAVA
</script>

<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.party_calldate.php';

$objUtility=new Utility();
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

$objParty_calldate=new Party_calldate();
$ptype=0;
if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>2)
$_tag=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if (!is_numeric($mtype))
$mtype=0;

$present_date=date('d/m/Y');
$mvalue=array();
$pkarray=array();

if ($_tag==1)//Post Back 
echo $objUtility->alert ("Updated");

$_tag=0;
if ($_tag==0)//Post Back 
{
$objParty_calldate->setCode("1");
if ($objParty_calldate->EditRecord()) //i.e Data Available
{ 
$mvalue[0]=$objParty_calldate->getCode();
$mvalue[1]=$objParty_calldate->getMydate();
$mvalue[2]=$objParty_calldate->getPolldate();
$mvalue[3]=$objParty_calldate->getAssemble_place();
$mvalue[4]=$objParty_calldate->getPoll_starttime();
$mvalue[5]=$objParty_calldate->getPoll_endtime();
$mvalue[6]=$objParty_calldate->getMplace();
$mvalue[7]=$objParty_calldate->getMdate();
$mvalue[8]=$objParty_calldate->getMsignature();
$mvalue[9]=0;//last Select Box for Editing
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
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
$mvalue[9]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=70%>
<form name=myform action=insert_party_calldate.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Update Particulars Related to Appointment Letter<br></font></td></tr>
<?php $i=0; ?>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Poll Date</font></td><td align=left bgcolor=white>
<input type=hidden size=8 name="Code" id="Code" value="<?php echo $mvalue[0]; ?>" onfocus="ChangeColor('Code',1)"  onblur="ChangeColor('Code',2)" onchange=direct1()>

    <input type=text size=10 name="Polldate" id="Polldate" value="<?php echo $mvalue[2]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Polldate',1)"  onblur="ChangeColor('Polldate',2)">
<font size=1 face=arial>dd/mm/yyyy</font>
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Polling Party Assemble Place</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Assemble_place" id="Assemble_place" value="<?php echo $mvalue[3]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=100 onfocus="ChangeColor('Assemble_place',1)"  onblur="ChangeColor('Assemble_place',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Poll Start Time</font></td><td align=left bgcolor=white>
<input type=text size=20 name="Poll_starttime" id="Poll_starttime" value="<?php echo $mvalue[4]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Poll_starttime',1)"  onblur="ChangeColor('Poll_starttime',2)">
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Poll End Time</font></td><td align=left bgcolor=white>
<input type=text size=20 name="Poll_endtime" id="Poll_endtime" value="<?php echo $mvalue[5]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Poll_endtime',1)"  onblur="ChangeColor('Poll_endtime',2)">
</td>
</tr>
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Signed by DEO<BR>(Use BR Tag if break required)</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Msignature" id="Msignature" value="<?php echo $mvalue[8]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=150 onfocus="ChangeColor('Msignature',1)"  onblur="ChangeColor('Msignature',2)">
</td>
</tr>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Place of Signature</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Mplace" id="Mplace" value="<?php echo $mvalue[6]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Mplace',1)"  onblur="ChangeColor('Mplace',2)">
</td>
</tr>
<?php $i++; //Now i=7?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Date of Issue of App.Letter</font></td><td align=left bgcolor=white>
<input type=text size=20 name="Mdate" id="Mdate" value="<?php echo $mvalue[7]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Mdate',1)"  onblur="ChangeColor('Mdate',2)">
<font size=1 face=arial>dd/mm/yyyy</font>
</td>
</tr>
<?php $i++; //Now i=8?>

<?php $i++; //Now i=9?>
<tr><td align=right bgcolor=#ccffcc>
<input type=button value="Proceed to Upload Seal"  name=Save onclick=proceed()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:yellow;color:black;width:180px">
</td><td align=left bgcolor=#ccffcc>
<input type=hidden size=50 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value="Update Detail"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:130px">
</td></tr>
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Code");

?>
<?php
include("footer.htm");
?>
</bo       
></body>
</html>
