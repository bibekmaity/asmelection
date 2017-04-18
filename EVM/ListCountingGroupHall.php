<html>
<title>Randomise Table/Hall for  Counting</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="SelectLac.php?tag=1";
}
function lock()
{
var name = confirm("Confirm?")
if (name == true)
{    
newform.action="LockCountingRandom.php";
newform.submit();
}
}
</script>
<body>


<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.lac.php';
require_once '../class/class.final.php';
require_once '../class/class.Countinggroup.php';
require_once '../class/class.Poling.php';


$objUtility=new Utility();
$objMg=new Countinggroup();
$objPol=new Poling();
//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$laccode=0;
if (isset($_GET['Lac']))
$laccode=$_GET['Lac'];
else
header('Location:index.php');
 
$objLac=new Lac();
$objLac->setCode($laccode);
$objLac->editRecord();
$lac=$laccode."-".$objLac->getName();

?>

<table border=1 align=center cellpadding=4 cellspacing=0 style=border-collapse: collapse; width=90%>
<Thead>
<tr>
<td colspan=6 align=Center bgcolor=#ccffcc><font face=arial size=4>HALL TABLE ALLOCATION FOR COUNTING GROUP FOR LAC NO-<b><?php echo $lac;?></b></font></td>
<tr>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
SLNO
</td>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
GROUP NO
</td>
<td align=center bgcolor="#FFFF33" WIDTH="30%"><font face=arial size=2>
NAME OF SUPERVISOR
</td>
<td align=center bgcolor="#FFFF33" WIDTH="30%"><font face=arial size=2>
NAME OF ASSISTANT
</td>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
HALL NO
</td>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
TABLE NO
</td>
</tr>

<?php

$objMg->setCondString(" Lac=".$laccode." and Hall_no>0 and Table_no>0 order by Grpno");
$row=$objMg->getAllRecord();
//echo $objPsname->returnSql;
//echo $objPsname->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
    
$grp=$row[$ii]['Grpno'];
//$rspan=count($myrow);
//if($rspan<1)
$rspan=1;
?>
<tr>
<td align=center valign="center"><font face=arial size=3>
<?php
echo ($ii+1);
?>
</td>
<td align=center valign="center"><font face=arial size=3>
<?php echo $row[$ii]['Grpno'];?>    
</td> 
<td align=left><font face=arial size=3><b>
<?php
$objPol->setSlno($row[$ii]['Sr']);
if($objPol->EditRecord())
{
$phone=$objPol->getPhone();
$tvalue=$objPol->getName ()."</b>,".$objPol->getDesig ()."<br>";  
if(strlen($phone)>=10)
$tvalue=$tvalue."Phone-".$phone;
echo $tvalue;
}
?>
</td>
<td align=left><font face=arial size=3><b>
<?php
$objPol->setSlno($row[$ii]['Ast1']);
if($objPol->EditRecord())
{
$phone=$objPol->getPhone();    
$tvalue=$objPol->getName ()."</b>,".$objPol->getDesig ()."<br>";  
if(strlen($phone)>=10)
$tvalue=$tvalue."Phone-".$phone;
echo $tvalue;
}
?>
</td>   
<td align=center valign="center"><font face=arial size=3><b>
<?php echo $row[$ii]['Hall_no'];?>    
</td>   
<td align=center valign="center"><font face=arial size=3></b>
<?php echo $row[$ii]['Table_no'];?>    
</td>     
</tr>
<?php
}
?>

</table>
</body>
</html>
