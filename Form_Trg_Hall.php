<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="Validation.js"></script>
<script language=javascript>
<!--
function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box
myform.Rsl.value=mvalue;
var a=myform.Venue_code.value ;
var b=myform.Rsl.value ;
if ( isNaN(a)==false && a!="" && isNaN(b)==false && b!="")
{
myform.action="Form_trg_hall.php?tag=2&ptype=0";
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
myform.Venue_code.focus();
}

function redirect(i)
{
myform.action="Form_trg_hall.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate()
{
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="TrgMenu.php?tag=1";
var a=myform.Venue_code.value ;
var a_index=myform.Venue_code.selectedIndex;
var b=myform.Rsl.value ;
var c=myform.Hall_number.value ;
var c_length=parseInt(c.length);
var d=myform.Hall_capacity.value ;
if ( a_index>0  && isNumber(b)==true   && 1==1 && validateString(c) && c_length<=15 && 1==1)
{
myform.action="Insert_trg_hall.php";
myform.submit();
}
else
alert('Invalid Data');
}



function home()
{
window.location="TrgMenu.php?tag=1";
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

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.trg_hall.php';
require_once './class/class.trg_venue.php';

$objUtility=new Utility();


//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify


$objTrg_hall=new Trg_hall();

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

$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[4]=0;
$mvalue[1]=$objTrg_hall->MaxRsl($mvalue[0]);
}
else
{
$mvalue[0]="0";//Venue_code
$mvalue[1]="0";//Rsl
$mvalue[2]="";//Hall_number
$mvalue[3]="0";//Hall_capacity
$mvalue[4]=0;
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
// Call $objTrg_hall->MaxVenue_code() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Venue_code
// Call $objTrg_hall->MaxRsl() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";
$mvalue[2]="";//Hall_number
// Call $objTrg_hall->MaxHall_capacity() Function Here if required and Load in $mvalue[3]
$mvalue[3]="0";//Hall_capacity
$mvalue[4]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;

//Post Back on Select Box Change,Hence reserve the value
if ($ptype==1)
{
// CAll MaxNumber Function Here if require and Load in $mvalue
if (isset($_POST['Venue_code']))
$mvalue[0]=$_POST['Venue_code'];
else
$mvalue[0]=0;

if (!is_numeric($mvalue[0]))
$mvalue[0]=-1;

$mvalue[1]=$objTrg_hall->MaxRsl($mvalue[0]);

if (isset($_POST['Hall_number']))
$mvalue[2]=$_POST['Hall_number'];
else
$mvalue[2]=0;

if (isset($_POST['Hall_capacity']))
$mvalue[3]=$_POST['Hall_capacity'];
else
$mvalue[3]=0;

if (isset($_POST['Editme']))
$mvalue[4]=$_POST['Editme'];
else
$mvalue[4]=0;

} //ptype=1

if (isset($_POST['Venue_code']))
$pkarray[0]=$_POST['Venue_code'];
else
$pkarray[0]=0;
$objTrg_hall->setVenue_code($pkarray[0]);
if (isset($_POST['Rsl']))
$pkarray[1]=$_POST['Rsl'];
else
$pkarray[1]=0;
$objTrg_hall->setRsl($pkarray[1]);
if ($objTrg_hall->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objTrg_hall->getVenue_code();
$mvalue[1]=$objTrg_hall->getRsl();
$mvalue[2]=$objTrg_hall->getHall_number();
$mvalue[3]=$objTrg_hall->getHall_capacity();
$mvalue[4]=0;//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]=$pkarray[1];
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=70%>
<form name=myform action=insert_trg_hall.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Manage Training Hall<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Training Venue</font></td><td align=left bgcolor=white>
<?php 
$objTrg_venue=new Trg_venue();
$objTrg_venue->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objTrg_venue->getRow();
?>
<select name=Venue_code style="font-family: Arial;background-color:white;color:black; font-size: 12px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>
<font color=red size=4 face=arial><b>*</b></font>
<?php $i++; //Now i=1?>
<input type=hidden size=8 name="Rsl" id="Rsl" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Rsl',1)"  onblur="ChangeColor('Rsl',2)" readonly>

</td>
</tr>

<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Hall Number</font></td><td align=left bgcolor=white>
<input type=text size=15 name="Hall_number" id="Hall_number" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=15 onfocus="ChangeColor('Hall_number',1)"  onblur="ChangeColor('Hall_number',2)">
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Hall Capacity</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Hall_capacity" id="Hall_capacity" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Hall_capacity',1)"  onblur="ChangeColor('Hall_capacity',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<tr><td align=right bgcolor=#ccffcc>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td><td align=left bgcolor=#ccffcc>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
</td></tr>
<tr><td align=right>
<?php 
$objTrg_hall->setCondString(" venue_code=".$mvalue[0]); //Change the condition for where clause accordingly
$row=$objTrg_hall->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 14px;width:100px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>
</td><td align=left>
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
</tr>
</table>
</form>
<?php

if($mtype==0)
echo $objUtility->focus("Venue_code");


if($mtype==1)//Postback from Venue_code
echo $objUtility->focus("Hall_number");

?>
<?php
include("footer.htm");
?>
</body>
</html>
