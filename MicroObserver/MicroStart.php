<?php
//include("MasterMenuhead.html");
?>
<script type="text/javascript" src="../validation.js"></script>
<script language=javascript>
<!--

function setMe()
{
myform.Lac.focus();
}

function Add(box)
{
var a=parseInt(myform.Totsel.value);
if (document.getElementById(box).checked==true)    
a=a+1;
else
a=a-1;    
myform.Totsel.value=a;

if(a>0)
myform.Save.disabled=false;
else
myform.Save.disabled=true;    
}


function enu()
{
var i=myform.Mgrp.selectedIndex;
if (i>0)
myform.Clr.disabled=false;
else
myform.Clr.disabled=true;
}

function direct()
{
var i=myform.Mgrp.selectedIndex;
if (i>0)
{

var name = confirm("Clear Selected Group? ");
if (name == true)
{
myform.action="MicroPSClear.php";
myform.submit();
}
}
}



function redirect(i)
{
myform.action="MicroStart.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate()
{

//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="../Mainmenu.php?tag=1";

var b_index=myform.Lac.selectedIndex;
var c=myform.Grpno.value ;
var d=parseInt(myform.Totsel.value);
if (b_index>0  && isNumber(c)==true && d>0)
{
var name = confirm("You have Selected "+d+" Poling Station");
if (name == true)
{
myform.action="Insert_Micro_Group.php";
myform.submit();
}
}
else
alert('Invalid Data');
}

function home()
{
window.location="./../Mainmenu.php?tag=1";
}



//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}


</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.microPS.php';
require_once 'header.php';

$objUtility=new Utility();
$objMicrops=new Microps();

//Start Verify
$allowedroll=2; //Change according to Business Logic

$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$objPsname=new Psname();

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
if(isset($_SESSION['msg']))
echo $objUtility->alert($_SESSION['msg']);

if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="0";//Lac
$mvalue[1]=$objMicrops->maxGrpno();//Grpno
}//end isset mvalue

if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
$cond=" Micro_Group=0 and Lac=".$mvalue[0]." limit 10";
}//tag=1 [Return from Action form]



if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objPsname->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac

$mvalue[1]=$objMicrops->maxGrpno();//Grpno
$_SESSION['mvalue']=$mvalue;

$cond=" 1=2";  //Alwayas False
}//tag=0[Initial Loading]


//$objPsname->ExecuteQuery("Create table Micro_Group add Micro_Group int not null default 0");
$objPsname->setCondstring("1=2");
$psrow=$objPsname->getAllRecord();

if ($_tag==2)//Post Back 
{
// CAll MaxNumber Function Here if require and Load in $mvalue
if (isset($_POST['Lac']))
$mvalue[0]=$_POST['Lac'];
else
$mvalue[0]=0;

$mvalue[1]=$objMicrops->maxGrpno();

$cond=" Micro_Group=0 and Lac=".$mvalue[0]." limit 10";

if($objPsname->rowCount($cond)==0)
echo $objUtility->alert ("All Poling Station for this LAC is Grouped for Micro Observer Deployment");    
} //tag==2


$objPsname->setCondstring($cond);
$psrow=$objPsname->getAllRecord();

//echo $mvalue[0];

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=96%>
<form name=myform action=""  method=POST >
<tr><td colspan=5 align=Center bgcolor=#ccffcc><font face=arial size=3><b>GROUP POLING STATION FOR MICRO OBSERVER DETAILMENT<font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select LAC Name</font></td><td align=left bgcolor=white colspan=4>
<?php 
$objLac=new Lac();
$objLac->setCondString(" Code>0 and Code in(Select distinct Lac from Psname)" ); //Change the condition for where clause accordingly
//$objLac->setCondString(" Code>0 and Code in(Select )" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Lac style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:200px" onchange=redirect(2)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Code'])
echo "<option selected value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
else
echo "<option  value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
}
?>
</select>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Group Number</font></td><td align=left bgcolor=white>
<input type=text size=4 name="Grpno" id="Grpno" value="<?php echo $mvalue[$i]; ?>" readonly>
</td><td align=right bgcolor=white colspan=2> 
<?php
$objMicrops->setCondstring("Lac=".$mvalue[0]);
$mrow=$objMicrops->getAllRecord();
?>
<select name=Mgrp style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:200px" onchange="enu()";>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select to Clear-
<?php 
for($ind=0;$ind<count($mrow);$ind++)
{
$plist="Group No.".$mrow[$ind]['Grpno']."(".$mrow[$ind]['Pslist'].")";
echo "<option  value=".chr(34).$mrow[$ind]['Grpno'].chr(34).">".$plist;
}
?>
</select>
</td>
<td align=cente bgcolor=white>
<input type=button value=Clear  name="Clr" id="Clr" onclick=direct()  style="font-family:arial; font-size: 12px ; background-color:red;color:blue;width:50px"  disabled>
</td>
</tr>

<tr>
<td align=CENTER bgcolor=white COLSPAN=5><font color=black size=2 face=arial>
SELECT PS NUMBER FOR THIS GROUP</font></td></tr>
<tr>
<td align=center bgcolor=#99CCCC>
<font color=black size=2 face=arial>
PS NO
</td>
<td align=center bgcolor=#99CCCC>
<font color=black size=2 face=arial>
PS NAME
</td>
<td align=center bgcolor=#99CCCC>
<font color=black size=2 face=arial>
TOTAL VOTER
</td>
<td align=center bgcolor=#99CCCC>
<font color=black size=2 face=arial>
STATUS
</td>
<td align=center bgcolor=#99CCCC>
<font color=black size=2 face=arial>
ADVANCE GROUP
</td>
<td align=center bgcolor=#99CCCC>
<font color=black size=2 face=arial>
SELECT
</td>
</TR>

<?php 

for($ind=0;$ind<count($psrow);$ind++)
{
$Sel="Sel".($ind+1);
$Adv="Adv".($ind+1);
?>
<tr>
<td align=center >
<font color=black size=2 face=arial>
<?php
echo $psrow[$ind]['Psno'];
?>
</td>
<td align=left >
<font color=black size=2 face=arial>
<?php
echo $psrow[$ind]['Psname'];
?>
</td>
<td align=center >
<font color=black size=2 face=arial>
<?php
echo $psrow[$ind]['Male']+$psrow[$ind]['Female'];
?>
</td>
<td align=center >
<font color=black size=2 face=arial>
<?php
echo $psrow[$ind]['Sensitivity'];
?>
</td>
<td align=center >
<font color=black size=2 face=arial>
<input type=hidden size="1" name="<?php echo $Adv;?>" id="<?php echo $Adv;?>" value="<?php echo $psrow[$ind]['Reporting_tag'];?>">
<?php
if ($psrow[$ind]['Reporting_tag']==0)
echo "Yes";
else
echo "No";    
?>
</td>
<td align=center >
<font color=black size=2 face=arial>
<input type=checkbox name="<?php echo $Sel;?>" id="<?php echo $Sel;?>" value="<?php echo $psrow[$ind]['Psno'];?>" onclick=Add('<?php echo $Sel;?>');>
</td>
</TR>
<?php
}
?>
</td>
</tr>
<TR><td>
       
</td><td align=right bgcolor=white colspan=3>
<font color=black size=2 face=arial>Total PS Selected
<input type=text size=1 name="Totsel" id="Msel" value="0" disabled>
   
<input type=button value="Make Group"  name=Save onclick=validate()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:black;width:100px" disabled>
&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td align=center bgcolor=white colspan=2>
<input type=button value="Menu"  name="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">
</td>
</tr>
</table>
</form>
<?php

if($mtype==13)//Postback from Reporting_tag
echo $objUtility->focus("Lac");

?>
<?php
if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);

if(isset($_SESSION['msg']))
unset($_SESSION['msg']);
include("footer.htm");
?>
</body>
</html>
