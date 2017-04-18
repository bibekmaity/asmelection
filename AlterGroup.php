<?php
require_once 'menuhead.html';
?>
<script type="text/javascript" src="validation.js"></script>
<script language="javascript">
<!--
function direct()
{
var i;
i=0;
}

function direct1()
{
var i;
i=0;
}
function setMe()
{
myform.Slno.focus();
}

function redirect(i)
{
a=myform.Slno.value;
b=myform.Slno1.value;
if(isNumber(a) && isNumber(b))
{
myform.action="AlterGroup.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}
}

function validate()
{
var a=myform.Pollcategory.value ;
var a1=myform.Pollcategory1.value ;
var b=myform.Grpno.value ;
var b1=myform.Grpno1.value ;
if (a==a1 && parseInt(b)>0 && parseInt(b1)>0)
{
var name = confirm("Confirm?")
if (name == true)
{
myform.action="AlterGroupN.php";
myform.submit();
}
}
}//End Validate


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

//Reset Form
function res()
{
window.location="AlterGroup.php?tag=0";
}
//END JAVA
</script>
<script language="JavaScript" src="./datepicker/htmlDatePicker.js" type="text/javascript"></script>
<link href="./datepicker/htmlDatePicker.css" rel="stylesheet"/>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.category.php';

$objUtility=new Utility();
$allowedroll=0; //Change according to Business Logic

$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: mainmenu.php?unauth=1');

//if($objUtility->CriticalAllowed()==false)
//header( 'Location: mainmenu.php?unauth=1');


$objPoling=new Poling();
$dis=" disabled";
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
$mtype=1;



$present_date=date('d/m/Y');
$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="0";//Slno
$mvalue[1]="";//Name
$mvalue[2]="";//Desig
$mvalue[3]="";//Department
$mvalue[4]="0";//Pollcategory
$mvalue[5]="0";//Grpno
$mvalue[6]="0";//Slno
$mvalue[7]="";//Name
$mvalue[8]="";//Desig
$mvalue[9]="";//Department
$mvalue[10]="0";//Pollcategory
$mvalue[11]="0";//Grpno
$mvalue[12]="0";//depcode
$mvalue[13]="0";//depcode1
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
// Call $objPoling->MaxSlno() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Slno
$mvalue[1]="";//Name
$mvalue[2]="";//Desig
$mvalue[3]="";//Department
// Call $objPoling->MaxPollcategory() Function Here if required and Load in $mvalue[4]
$mvalue[4]="0";//Pollcategory
$mvalue[5]="0";
$mvalue[6]="0";//Slno
$mvalue[7]="";//Name
$mvalue[8]="";//Desig
$mvalue[9]="";//Department
$mvalue[10]="0";//Pollcategory
$mvalue[11]="0";//Grpno
$mvalue[12]="0";//depcode
$mvalue[13]="0";//depcode

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
if ($mtype==1) //Edit First ID Detail
{
if (isset($_POST['Slno']))
$mvalue[0]=$_POST['Slno'];
else
$mvalue[0]=0;
$objPoling->setSlno($mvalue[0]);
if($objPoling->Editrecord())
{
$mvalue[1]=$objPoling->getName();
$mvalue[2]=$objPoling->getDesig();
$mvalue[3]=$objPoling->getDepartment();
$mvalue[4]=$objPoling->getPollcategory();
$mvalue[5]=$objPoling->getGrpno();
$mvalue[12]=$objPoling->getDepcode();
}
else
{
$mvalue[1]="";//Name
$mvalue[2]="";//Desig
$mvalue[3]="";//Department
$mvalue[4]="0";//Pollcategory
$mvalue[5]="0";
$mvalue[12]="0";
}

if (isset($_POST['Slno1']))
$mvalue[6]=$_POST['Slno1'];
else
$mvalue[6]=0;
if (isset($_POST['Name1']))
$mvalue[7]=$_POST['Name1'];
else
$mvalue[7]=0;

if (isset($_POST['Desig1']))
$mvalue[8]=$_POST['Desig1'];
else
$mvalue[8]=0;

if (isset($_POST['Department1']))
$mvalue[9]=$_POST['Department1'];
else
$mvalue[9]=0;

if (isset($_POST['Pollcategory1']))
$mvalue[10]=$_POST['Pollcategory1'];
else
$mvalue[10]=0;

if (isset($_POST['Grpno1']))
$mvalue[11]=$_POST['Grpno1'];
else
$mvalue[11]=0;

if (isset($_POST['Dcode1']))
$mvalue[13]=$_POST['Dcode1'];
else
$mvalue[13]=0;

} //mtype=1

if ($mtype==2) //Edit Second ID Detail
{
if (isset($_POST['Slno1']))
$mvalue[6]=$_POST['Slno1'];
else
$mvalue[6]=0;
$objPoling->setSlno($mvalue[6]);
if($objPoling->Editrecord())
{
$mvalue[7]=$objPoling->getName();
$mvalue[8]=$objPoling->getDesig();
$mvalue[9]=$objPoling->getDepartment();
$mvalue[10]=$objPoling->getPollcategory();
$mvalue[11]=$objPoling->getGrpno();
$mvalue[13]=$objPoling->getDepcode();
}
else
{
$mvalue[7]="";//Name
$mvalue[8]="";//Desig
$mvalue[9]="";//Department
$mvalue[10]="0";//Pollcategory
$mvalue[11]="0";
$mvalue[13]="0";
}

if (isset($_POST['Slno']))
$mvalue[0]=$_POST['Slno'];
else
$mvalue[0]=0;
if (isset($_POST['Name']))
$mvalue[1]=$_POST['Name'];
else
$mvalue[1]=0;

if (isset($_POST['Desig']))
$mvalue[2]=$_POST['Desig'];
else
$mvalue[2]=0;

if (isset($_POST['Department']))
$mvalue[3]=$_POST['Department'];
else
$mvalue[3]=0;

if (isset($_POST['Pollcategory']))
$mvalue[4]=$_POST['Pollcategory'];
else
$mvalue[4]=0;

if (isset($_POST['Grpno']))
$mvalue[5]=$_POST['Grpno'];
else
$mvalue[5]=0;

if (isset($_POST['Dcode']))
$mvalue[12]=$_POST['Dcode'];
else
$mvalue[12]=0;

} //mtype=2
} //tag==2

if($mvalue[4]==$mvalue[10] && $mvalue[5]>0 && $mvalue[11]>0)
$dis="";
else
$dis=" disabled";


//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=insert_poling.php  method=POST >
<tr>
<td colspan=4 align=Center >
<font face=arial size=3>Alter Person in Poling Group
</td>
</tr>
<?php $i=0; ?>
<?php //row1?>
<tr>
<td align=right bgcolor=#FFCC00 width=15%>
<font color=black size=2 face=arial>
Enter First ID
</font>
</td>
<td align=left bgcolor=#FFCC00 width=25%>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=4 name="Slno" id="Slno" value="<?php echo $mvalue[0]; ?>" onfocus="ChangeColor('Slno',1)"  onblur="ChangeColor('Slno',2)" onchange=redirect(1)>
<input type=hidden size=1 name="Dcode" id="Dcode" value="<?php echo $mvalue[12]; ?>" >

</td>
<?php $i++; //Now i=1?>
<td align=right bgcolor=white width=15%>
<font color=black size=2 face=arial>
Name
</font>
</td>
<td align=left bgcolor=white width=45%><font color=black size=2 face=arial>
<?php
echo $mvalue[1];
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=hidden size=50 name="Name" id="Name" value="<?php echo $mvalue[1]; ?>" style="<?php echo $mystyle;?>"  maxlength=100 onfocus="ChangeColor('Name',1)"  onblur="ChangeColor('Name',2)">
</td>
</tr>
<?php $i++; //Now i=2?>
<?php //row2?>
<tr>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Desig
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial><?php echo $mvalue[2];
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=hidden size=50 name="Desig" id="Desig" value="<?php echo $mvalue[2]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Desig',1)"  onblur="ChangeColor('Desig',2)">
</td>
<?php $i++; //Now i=3?>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Department/Office
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial><?php echo $mvalue[3];
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=hidden size=50 name="Department" id="Department" value="<?php echo $mvalue[3]; ?>" style="<?php echo $mystyle;?>"  maxlength=200 onfocus="ChangeColor('Department',1)"  onblur="ChangeColor('Department',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<?php //row3?>
<tr>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Poll Category
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial><?php echo $objUtility->CategoryList[$mvalue[4]];?>
<input type=hidden size=2 name="Pollcategory" id="Pollcategory"  value="<?php echo $mvalue[4];?>">
</td>
<?php $i++; //Now i=5?>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Group No
</font>
</td>
<td align=left bgcolor=white><font color=black size=2 face=arial>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
echo "Group-".$mvalue[5]." (";
echo $objUtility->LacList[$objPoling->DutyLAC($mvalue[5])];
?>)
<input type=hidden size=8 name="Grpno" id="Grpno" value="<?php echo $mvalue[5]; ?>" onfocus="ChangeColor('Grpno',1)"  onblur="ChangeColor('Grpno',2)">
</td>
</tr>
<TR><td colspan=4>&nbsp;</td></tr>
<tr>
<td align=right bgcolor=#FF99FF>
<font color=black size=2 face=arial>
Enter Second ID
</font>
</td>
<td align=left bgcolor=#FF99FF>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=4 name="Slno1" id="Slno1" value="<?php echo $mvalue[6]; ?>" onfocus="ChangeColor('Slno1',1)"  onblur="ChangeColor('Slno1',2)" onchange=redirect(2)>
<input type=hidden size=1 name="Dcode1" id="Dcode1" value="<?php echo $mvalue[13]; ?>" >

</td>
<?php $i++; //Now i=1?>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Name
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial>
<?php
echo $mvalue[7];
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=hidden size=50 name="Name1" id="Name1" value="<?php echo $mvalue[7]; ?>" style="<?php echo $mystyle;?>"  maxlength=100 onfocus="ChangeColor('Name',1)"  onblur="ChangeColor('Name',2)">
</td>
</tr>
<?php $i++; //Now i=2?>
<?php //row2?>
<tr>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Designation
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial>
<?php
echo $mvalue[8];
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=hidden size=50 name="Desig1" id="Desig1" value="<?php echo $mvalue[8]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Desig',1)"  onblur="ChangeColor('Desig',2)">
</td>
<?php $i++; //Now i=3?>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Department/Office
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial>
<?php
echo $mvalue[9];
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=hidden size=50 name="Department1" id="Department1" value="<?php echo $mvalue[9]; ?>" style="<?php echo $mystyle;?>"  maxlength=200 onfocus="ChangeColor('Department',1)"  onblur="ChangeColor('Department',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<?php //row3?>
<tr>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Poll Category
</font>
</td>
<td align=left bgcolor=white>
<font color=black size=2 face=arial><?php echo $objUtility->CategoryList[$mvalue[10]];?>
<input type=hidden size=2 name="Pollcategory1" id="Pollcategory1"  value="<?php echo $mvalue[10];?>">
</td>
<?php $i++; //Now i=5?>
<td align=right bgcolor=white>
<font color=black size=2 face=arial>
Group No
</font>
</td>
<td align=left bgcolor=white><font color=black size=2 face=arial>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
echo "Group-".$mvalue[11]." (";
echo $objUtility->LacList[$objPoling->DutyLAC($mvalue[11])];
?>)
<input type=hidden size=8 name="Grpno1" id="Grpno1" value="<?php echo $mvalue[11]; ?>" onfocus="ChangeColor('Grpno',1)"  onblur="ChangeColor('Grpno',2)">
</td>
</tr>


<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white>

</td>
<td align=left bgcolor=white>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:150px";
?>
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value="Alter Person"  name=Save onclick=validate() style="<?php echo $mystyle;?>"  <?php echo $dis;?>>
</td>
<td align=left bgcolor=white>&nbsp;</td><td align=left bgcolor=white>&nbsp;</td>
</tr>
</table>
</form>
<?php

if($mtype==1)//Postback from Remarks
echo $objUtility->focus("Slno1");

if($mtype==2 || $mtype==0)//Postback from Remarks
echo $objUtility->focus("Slno");

if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);
?>
</body>
</html>
