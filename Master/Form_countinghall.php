<?php
include("MasterMenuhead.html");
?>
<script type="text/javascript" src="../validation.js"></script>
<script language="javascript">
<!--
function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Hall.value=mvalue;

var a=myform.Hall.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="Form_countinghall.php?tag=2&ptype=0";
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
myform.Hall.focus();
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
//window.location="mainmenu.php?tag=1";
var a=myform.Hall.value ;// Primary Key
var b=myform.Lac.value ;
var b_index=myform.Lac.selectedIndex;
var c=myform.Start_table.value ;
var d=myform.No_of_table.value ;
var e=myform.Ro_name.value ;
var e_length=parseInt(e.length);
if ( nonZero(a)==true   && b_index>0  && 1==1 && 1==1 && 1==1 && validateString(e) && e_length<=40)
{
//myform.setAttribute("target","_self");//Open in Self
//myform.setAttribute("target","_blank");//Open in New Window
myform.action="Insert_countinghall.php";
myform.submit();
}
else
alert('Invalid Data');
}

function res()
{
window.location="form_countinghall.php?tag=0";
}



function home()
{
window.location="mainmenu.php?tag=1";
}



//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
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
require_once '../class/utility.class.php';
require_once '../class/class.countinghall.php';
require_once '../class/class.lac.php';

$objUtility=new Utility();
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: index.php');

$objCountinghall=new Countinghall();

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

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[5]=0;
}
else
{
$mvalue[0]="0";//Hall
$mvalue[1]="0";//Lac
$mvalue[2]="0";//Start_table
$mvalue[3]="0";//No_of_table
$mvalue[4]="";//Ro_name
$mvalue[5]=0;
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
// Call $objCountinghall->MaxHall() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Hall
// Call $objCountinghall->MaxLac() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Lac
// Call $objCountinghall->MaxStart_table() Function Here if required and Load in $mvalue[2]
$mvalue[2]="0";//Start_table
// Call $objCountinghall->MaxNo_of_table() Function Here if required and Load in $mvalue[3]
$mvalue[3]="0";//No_of_table
$mvalue[4]="";//Ro_name
$mvalue[5]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Hall']))
$pkarray[0]=$_POST['Hall'];
else
$pkarray[0]=0;
$objCountinghall->setHall($pkarray[0]);
if ($objCountinghall->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objCountinghall->getHall();
$mvalue[1]=$objCountinghall->getLac();
$mvalue[2]=$objCountinghall->getStart_table();
$mvalue[3]=$objCountinghall->getNo_of_table();
$mvalue[4]=$objCountinghall->getRo_name();
$mvalue[5]=0;//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]=-1;
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]="";
$mvalue[5]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<form name=myform action=insert_countinghall.php  method=POST >
<tr>
<td colspan=2 align=Center bgcolor=#ccffcc>
<font face=arial size=3>MANAGE COUNTING HALL<br></font>
<font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font>
</td>
</tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Hall Number
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=8 name="Hall" id="Hall" value="<?php echo $mvalue[0]; ?>" onfocus="ChangeColor('Hall',1)"  onblur="ChangeColor('Hall',2)" onchange=direct1()>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Name of LAC
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family: Arial;background-color:white;color:black;font-size: 14px;width:160px";
$objLac=new Lac();
$objLac->setCondString("Code>0" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Lac style="<?php echo $mystyle;?>" onchange=redirect(2)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind]['Code'];
$mdetail=$row[$ind]['Name'];
if ($mvalue[1]==$mcode)
{
?>
<option selected value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
else
{
?>
<option  value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
} //for loop
?>
</select>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Start Table No
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=8 name="Start_table" id="Start_table" value="<?php echo $mvalue[2]; ?>" onfocus="ChangeColor('Start_table',1)"  onblur="ChangeColor('Start_table',2)">
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Total Table
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=8 name="No_of_table" id="No_of_table" value="<?php echo $mvalue[3]; ?>" onfocus="ChangeColor('No_of_table',1)"  onblur="ChangeColor('No_of_table',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Name of Returning Officer
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=40 name="Ro_name" id="Ro_name" value="<?php echo $mvalue[4]; ?>" style="<?php echo $mystyle;?>"  maxlength=40 onfocus="ChangeColor('Ro_name',1)"  onblur="ChangeColor('Ro_name',2)">
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=#FFFFCC>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:100px";
?>
<input type=hidden size=40 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value=Save/Update  name=Save onclick=validate() style="<?php echo $mystyle;?>">
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:red;color:black;width:100px";
?>
</td></tr>
<tr><td align=right>
<?php
$mystyle="font-family:arial; font-size: 14px ; background-color:white;color:black;width:150px";

$objCountinghall->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objCountinghall->getRow();
?>
<select name=Editme style="<?php echo $mystyle;?>" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind]['Hall'];
$mdetail=$row[$ind]['Ro_name'];
if ($mvalue[5]==$mcode)
{
?>
<option selected value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
else
{
?>
<option  value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
} //for loop
?>
</select>
</td>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:yellow;color:black;width:100px";
?>

<td align=left>
<input type=button value=Edit  name=edit1 onclick=direct() style="<?php echo $mystyle;?>" disabled>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:green;color:black;width:100px";
?>
<input type=button value=Reset  name=res1 onclick=res() style="<?php echo $mystyle;?>" >
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Hall");

if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);
?>
</body>
</html>
