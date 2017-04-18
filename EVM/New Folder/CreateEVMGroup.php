<?php
include("EVMMenuhead.html");
?>

<script language=javascript>
<!--
function reload(i)
{
document.getElementById('idno').value=i;   
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

function home()
{
window.location="EVMMenu.php?tag=1";
}

function go()
{
var j=parseInt(document.getElementById('idno').value);
if(j>0)
{
myform.Save1.disabled=true;   
myform.action="CreateEVMGroup.php?tag=2";
myform.submit();
document.getElementById('Result').innerHTML="<image src=../image/Star.gif width=50 height=50><br><b><font size=4 face=arial>Creating EVM Group...Please Wait </font></b>";
}
else
alert('Select Any LAC');
}//go

function check(a)
{
var b=document.getElementById(a).value;
//var b=a.value;
if (isNumber(b)==false)
{
alert('Invalid Number');
document.getElementById(a).value=0;
}
   
}
</script>

<body onload=setMe()>
<?php
session_start();
require_once '../class/class.lac.php';
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.final.php';
require_once './class/class.evmgroup.php';
require_once './class/class.BU.php';
require_once './class/class.CU.php';


$objUtility=new Utility();
$objLac=new Lac();
//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify



$objPs=new Psname();
$objEvm=new Evmgroup();
$objBU=new Bu();
$objCU=new Cu();

$objF=new LacFinal();

if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;


if($code==0 && $mtype==100 && isset($_SESSION['msg']))
{    
echo $objUtility->alert ($_SESSION['msg']);
$_SESSION['msg']="";
}

if ($code==2) //PostBack Submit
{
//echo $_SESSION['rowcount'];
$t2= date('H:i:s');
$tt="";
$ind=$_POST['idno'];
//for ($ind=1;$ind<=$_SESSION['rowcount'];$ind++)
//{
$oldCode="Old_Code".$ind;
$Code=$_POST[$oldCode];

$Sel="Sel".$ind;
$Clr="Clr".$ind;
$Res="Res".$ind;

if (isset($_POST[$Res]))
$Res=$_POST[$Res];
else
$Res=0;

if (isset($_POST[$Clr])) //Clear Group
{
$sql="update CU set used='N' where Cu_code in(select CU from evmgroup where lac=".$Code.")";
$res1=$objEvm->ExecuteQuery($sql); 
$sql="update BU set used='N' where Bu_code in(select BU from evmgroup where lac=".$Code.")";
$res2=$objEvm->ExecuteQuery($sql); 

$sql="delete from evmgroup where lac=".$Code;
if ($res1 && $res2)
$objEvm->ExecuteQuery($sql);   
$tt=$tt." Cleared Group for LAC-".$Code;
}


if (isset($_POST[$Sel])) //Create Main an Reserve Group
{
//$objUtility->saveSqlLog("Temp","LAC=".$Code) ;   

$totrow=$objPs->rowCount("Lac=".$Code);
$totrow=$totrow+round(($totrow*$Res)/100);
//echo $totrow;
//$objUtility->saveSqlLog("Temp","required=".$totrow) ; 

$cuArr=$objCU->getTopId($totrow);
$buArr=$objBU->getTopId($totrow);

$cuInd=0;
$buInd=0;

//echo count($cuArr)."-".count($buArr);

if (count($cuArr)<count($buArr))
$tcount= count($cuArr);
else
$tcount= count($buArr);


if($tcount<$totrow) //Not Sifficient no of CU and BU
{
//$objUtility->saveSqlLog("Temp","Required-".$totrow." Available-".$tcount." So failed") ;     
$tt=$tt." Deficinecy of CU/BU to form Group for LAC-".$Code.";Required ".$totrow.": Available ".$tcount;
}
else
{
$tt=$tt." Group Formed for LAC-".$Code;     
//$objUtility->saveSqlLog("Temp","CU selected=".$tcount) ; 
$objPs->setCondString("Lac=".$Code." order by PSNO");   
$row=$objPs->getAllRecord();
//$objUtility->saveSqlLog("Temp","PS found=".count($row)) ; 

for ($i=0;$i<count($row);$i++)
{
$objUtility->saveSqlLog("Temp","i=".$i);
$rcode=$row[$i]['Rcode'];  
$j=$objEvm->maxGrpno();
$objEvm->setGrpno($j);
$objEvm->setLac($Code);
$objEvm->setReserve("N");
$objEvm->setRcode($rcode); 
$objEvm->setCu($cuArr[$cuInd]);
$objEvm->setBu($buArr[$buInd]);

if ($objEvm->SaveRecord())
{
$objBU->setBu_code($buArr[$buInd]);
$objBU->setUsed("Y");
$objBU->setRnumber(rand());
$objBU->UpdateRecord();

$objCU->setCu_code($cuArr[$cuInd]);
$objCU->setUsed("Y");
$objCU->setRnumber(rand());
$objCU->UpdateRecord();

$cuInd++;
$buInd++;
}  
//$objUtility->saveSqlLog("Temp",$objEvm->returnSql) ; 
//$objUtility->saveSqlLog("Temp",$objBU->returnSql) ; 
//$objUtility->saveSqlLog("Temp",$objCU->returnSql) ; 
}//for loop Main Group
//Reserve Group
//$objUtility->saveSqlLog("Temp","Reserve") ; 
for ($id=$i;$id<$tcount;$id++)
{
$j=$objEvm->maxGrpno();
$objEvm->setGrpno($j);
$objEvm->setLac($Code);
$objEvm->setReserve("Y");
//$objEvm->setRcode($rcode); 
$objEvm->setCu($cuArr[$cuInd]);
$objEvm->setBu($buArr[$buInd]); 
if ($objEvm->SaveRecord())
{
$objBU->setBu_code($buArr[$buInd]);
$objBU->setUsed("R");
$objBU->setRnumber(rand());
$objBU->UpdateRecord();

$objCU->setCu_code($cuArr[$cuInd]);
$objCU->setUsed("R");
$objCU->setRnumber(rand());
$objCU->UpdateRecord();    
$cuInd++;
$buInd++;
}    
//$objUtility->saveSqlLog("Temp",$objEvm->returnSql) ; 
//$objUtility->saveSqlLog("Temp",$objBU->returnSql) ; 
//$objUtility->saveSqlLog("Temp",$objCU->returnSql) ; 
} // for loop  reserve Selection
} //if tcount<totrow
}//is isset
//}//for loop LAC LOOP


$tt=$tt."(Query took ";
$t1= date('H:i:s');
$mrow=$objUtility->elapsedTime($t1, $t2);
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Minutes ";
if ($mrow['s']>0)
$tt= $tt.$mrow['s']." Second";
$tt= $tt.")";

$_SESSION['msg']=$tt;

//header( 'Location: CreateEVMGroup.php?tag=0&mtype=100');
echo $objUtility->AlertNRedirect("", "CreateEVMGroup.php?tag=0&mtype=100");
}//code=2


$sql=" code>0 and code in(select distinct lac from psname)";
?>
    <div align="center" id="Result">
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<form name=myform action=CreateEVMGroup?tag=2  method=POST >
    <tr><td colspan="7" align="center">
  <font face="arial" size="2">Select LAC for EVM Group Formation          
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
<font face="arial" size="2">Reserve%
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Select
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Clear
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">(Click to Display)
</td>
</tr>
<?php
$rowcount=0;

$objLac->setCondString($sql);
$row=$objLac->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$stat="";
$rowcount++;
$cond=" lac=".$row[$ii]['Code'];
$c1=$objPs->rowCount($cond);
$cond=" Reserve='N' and lac=".$row[$ii]['Code'];
$c2=$objEvm->rowCount($cond);
$lock=false;
if ($c1>0 && $c1==$c2)
{    
$dis1=" disabled";
$dis2=" ";
$stat="<font face=arial size=2 color=blue>Group Formed";
}
else
{
$dis1="";
$dis2=" disabled";
}

$objF->setLac($row[$ii]['Code']);
$objF->setMtype("3"); //3 For EVM Group
if ($objF->EditRecord())
{  
$lock=true;
$dis2=" disabled";
$stat="<font face=arial size=2 color=red>Group Locked";
}

?>
<tr>
<?php  $Code="Code".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=hidden name="<?php echo $Code;?>" size=5    value="<?php echo $row[$ii]['Code'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px" readonly>
<input type=hidden name=Old_<?php echo $Code;?>  value="<?php echo $row[$ii]['Code'];?>">
<?php echo $row[$ii]['Code'];?>
</td>
<?php  $Name="Name".$rowcount; ?>
<td align=left><font face="arial" size="2">
<input type=hidden name="<?php echo $Name;?>" size=30    value="<?php echo $row[$ii]['Name'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px">
<input type=hidden name=Old_<?php echo $Name;?>  value="<?php echo $row[$ii]['Name'];?>">
<?php echo $row[$ii]['Name'];?>
</td>
<td align=center><font face="arial" size="2"><?php echo $c1;?></td>
<?php $Res="Res".$rowcount; ?>
<td align=center>
<input type=text size="4" name="<?php echo $Res;?>" id="<?php echo $Res;?>" value="20" onchange="check('<?php echo $Res;?>')"  <?php echo $dis1;?> >
</td>
<?php  $Sel="Sel".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=checkbox name="<?php echo $Sel;?>" <?php echo $dis1;?> onclick="reload(<?php echo $ii+1;?>)">
</td>
<?php  $Clr="Clr".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=checkbox name="<?php echo $Clr;?>" <?php echo $dis2;?> onclick="reload(<?php echo $ii+1;?>)">
</td>
<td align=center>&nbsp;
<?php if ($lock==true) {?>
<image src="../image/printer.png" width="15" height="20" alt="Click Here to View Detail in PDF">
<a href="EVMGroupPDF.php?code=<?php echo $row[$ii]['Code'];?>" target="_blank">
<?php } else {?>    
<a href="ShowEVMGroup.php?code=<?php echo $row[$ii]['Code'];?>">
<?php 
}
echo $stat;
?></a>
</td>
</tr>

<?php
} //while
$_SESSION['rowcount']=$rowcount;
?>

<tr><td align=right bgcolor=#FFFFCC>
</td><td align=left bgcolor=#FFFFCC colspan="6">
<input type="hidden" size="1" name="idno" id="idno" value="0">  
<input type=button value=Process  name=Save1 onclick="go()">
</td></tr>
</table>
  
    
</form>
</div>       
<?php
include("footer.htm");
?>       
</body>
</html>
