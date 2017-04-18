<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>
<script language=javascript>
<!--
function home()
{
window.location="Mainmenu.php?tag=1";
}

function enu(i)
{
myform.Lac.value=i;
}

function go()
{

var a=myform.Res.value;
var b=myform.Lac.value;
if (isNumber(a) && nonZero(b))
{
myform.Save1.disabled=true;   
myform.action="ClearGroupN.php?tag=0";
myform.submit();
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=50 height=50><br><b><font size=4 face=arial>Processing...Please Wait </font></b>";
}
else
alert('Select LAC and Reserve Percentage');
}

function proceed(code)
{
//alert(code);
var name = confirm("Are U Sure?")
if (name == true)    
window.location="ClearPolingGroup.php?code="+code;

}

</script>
<BODY>
<script language=javascript>
<!--
</script>
<body onload=setMe()>
<?php
session_start();
require_once './class/class.lac.php';
require_once './class/utility.class.php';
require_once './class/class.Polinggroup.php';
require_once './class/class.psname.php';
require_once './class/class.final.php';
require_once './class/class.poling.php';

$objUtility=new Utility();
$objP=new Poling();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify


if($objP->FirstLevelCompleted()==false)
{
$_SESSION['catchmessage']="FIRST LEVEL RANDOMISATION NOT COMPLETED";
header( 'Location: CatchMsg.php');
}    

$objLac=new Lac();

$objF=new Lacfinal();

$objPs=new Psname();
$objPg=new Polinggroup();

if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;

if(!is_numeric($code))
$code=0;

if($code==1)
{
if(isset($_SESSION['msg']))
echo $objUtility->alert($_SESSION['msg']);    
}

$sql=" code>0 and code in(select distinct lac from psname)";
?>
 <div align="center" id="Result">    
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=85%>
<form name=myform action=ClearGroup.php?tag=2  method=POST >
    <tr><td colspan="5" align="center">
  <font face="arial" size="2"><B>FIRST STEP FOR GROUP FORMATION</B>         
        </td></tr>
<tr>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">LAC Code
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">LAC Name
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Total PS
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Select
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Status
</td>
</tr>
<?php
$rowcount=0;
$c1=0;
$c2=0;
$objLac->setCondString($sql);
$row=$objLac->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$laccode=$row[$ii]['Code'];    
$rowcount++;
$cond=" lac=".$row[$ii]['Code'];
$c1=$objPs->rowCount($cond);
$c2=$objPg->rowCount($cond);

if($objLac->groupStatus($laccode)==0)
$dis="";
else
$dis=" disabled";


    
?>
<tr>
<?php  $Code="Code".$rowcount; ?>
<td align=center><font face="arial" size="2">
<?php $objLac->groupStatus($laccode); ?>    
<input type=hidden name="<?php echo $Code;?>" size=5    value="<?php echo $row[$ii]['Code'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px" readonly>
<input type=hidden name=Old_<?php echo $Code;?>  value="<?php echo $row[$ii]['Code'];?>">
<?php echo $row[$ii]['Code'];?>
</td>
<?php  $Name="Name".$rowcount; ?>
<td align=left><font face="arial" size="2">
<?php echo $row[$ii]['Name'];?>
</td>
<td align=center><font face="arial" size="2"><?php echo $c1;?></td>
<?php  $Sel="Sel".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=radio name="myLac"  onclick="enu(<?php echo $row[$ii]['Code'];?>)"  <?php echo $dis;?>>
</td>
<td align=center><font face="arial" size="2">
<?php 
$status=$objLac->groupStatusDetail($row[$ii]['Code']);
echo "<font color=blue>".$status;
if($c2>0)
echo "[".$c2." Nos]"."</font>"   
?>
</td>
</tr>
<?php
} //while
?>
<tr><td align=right bgcolor=#CCFFCC colspan="2">
<font face="arial" size="2">Percent of Reserve
</td><td align=center bgcolor=#CCFFCC colspan="2">
<input type="text" name="Res" size="3" value="20">
<input type="hidden" name="Lac" size="4" readonly>
%
<td align="center" bgcolor=#CCFFCC>    
<input type=button value=Process  name=Save1  style="font-family: Arial;background-color:orange;color:black;font-size: 12px;font-weight:bold;"  onclick="go()">
</td></tr>
</table>
 
</form>
</div>
<?php
if(isset($_SESSION['msg']))
unset($_SESSION['msg']);
include("footer.htm");
?>       
</body>
</html>
