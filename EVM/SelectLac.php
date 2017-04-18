<?php
//include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>
<script language=javascript>
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
myform.Lac.focus();
}

function redirect(i)
{
}

function validate()
{


var b_index=parseInt(myform.Lac.value);

if (b_index>0)
{
myform.Save.disabled=true;
myform.hm.disabled=true;
myform.action="RandomiseHall.php";
myform.submit();
}
else
alert('Invalid Data');
}


function load(i)
{
    
//alert(i);
myform.Lac.value=i;
myform.Save.disabled=false;
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
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.final.php';
require_once '../class/class.Microgroup.php';
require_once '../class/class.party_calldate.php';
require_once '../class/class.Countinggroup.php';

$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify
$objLac=new Lac();
$objPsname=new Psname();
$objF=new LacFinal();

if($objLac->CommonCountgroupStatus()<4)
{
$_SESSION['catchmessage']="COUNTING GROUP SELECTION NOT DONE OR NOT LOCKED";
header( 'Location: ../CatchMsg.php');
}


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
if(isset($_SESSION['msg']))
echo $objUtility->alert ($_SESSION['msg']);   
    
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="0";//Lac
$mvalue[1]="0";//Psno
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
// Call $objPsname->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac
// Call $objPsname->MaxPsno() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Psno
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]


//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=95%>
<form name=myform action=""  method=POST >
<tr><td colspan="6" align="center" BGCOLOR="#CC33FF">
<font face="arial" size="2"><B>SELECT LAC FOR HALL/TABLE ALLOCATION TO COUNTING GROUP</B>         
</td></tr>
<tr>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=blue>
<font face="arial" size="2" ><B>LAC Code
</td>
<td align=center bgcolor=#CCFFCC width="25%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>LAC Name
</td>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Total Group
</td>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Click Select
</td>
<td align=center bgcolor=#CCFFCC width="30%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Status(Click to View)
<input type="hidden" name="Lac" size="1" value="0">
</td>
</tr>
<?php 
$objMg=new Countinggroup();


$objLac->setCondString(" code >0 order by code" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
//echo $objLac->returnSql;
$dis="";
$msg="&nbsp;";
for($ind=0;$ind<count($row);$ind++)
{
$laccode=$row[$ind]['Code'];
$cond="Lac=".$laccode;    
$tgrp=$objMg->rowCount($cond);    
$gstatus=$objLac->CountinggroupStatus($laccode);  
//$msg=$objLac->MicrogroupStatusDetail($laccode);
$msg="&nbsp;";
if($gstatus==4 )//group Locked
{    
$dis="";    
$msg="Group Locked";
}
else
$dis=" disabled";

if($gstatus==6)
$msg="Hall Table Allocation Done";
if($gstatus==3)
$msg="Group Constructed";

if($gstatus==6)
$msg="<A href=ListCountingGroupHall.php?Lac=".$laccode." target=_blank>".$msg."</a>";    

?>
<tr>
<td align=center ><font size=2 face=arial color=blue>
<font face="arial" size="2"><?php echo $row[$ind]['Code'];?>
</td>
<td align=left ><font size=2 face=arial color=blue>
<font face="arial" size="2"><?php echo $row[$ind]['Name'];?>
</td>
<td align=center ><font size=2 face=arial color=blue>
<font face="arial" size="2">
<?php 
echo $tgrp;?>
</td>
<td align=center ><font size=2 face=arial color=blue>
<input type="radio" name="Sel" value="<?php echo $laccode;?>" onclick="load(<?php echo $laccode;?>)" <?php echo $dis;?>>
</td>
<td align=center ><font size=2 face=arial color=blue>
<?php 
echo $msg;    
?>
</td>
<?php 
}//for loop for LAC
?>
<tr><td align=right bgcolor=white>
</td><td align=left bgcolor=white colspan="4">
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value="Randomly Allocate Hall/Table"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;width:250px" disabled>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value="Menu"  name="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">
</td></tr>
</table>
</form>

<?php
if(isset($_SESSION['msg']))
unset($_SESSION['msg']);
include("footer.htm");
?>   
</body>
</html>
