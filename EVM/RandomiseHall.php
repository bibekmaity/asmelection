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
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$laccode=0;
if (isset($_POST['Lac']))
$laccode=$_POST['Lac'];
else
header('Location:index.php');
 
$objLac=new Lac();
$objLac->setCode($laccode);
$objLac->editRecord();
$lac=$laccode."-".$objLac->getName();


$t2= date('H:i:s'); //set initial time
$tt="";
$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("8");

$objF->setTag("1"); //Already Randomised 
if($objF->EditRecord())
$Code=0;
else
$Code=1;    


if($Code==1) //Randomise for Advance Day
{
$objMg->RandomiseGroup($laccode);
}
?>

<table border=1 align=center cellpadding=4 cellspacing=0 style=border-collapse: collapse; width=90%>
<Thead>
<tr>
<td align="center">    
 <input type=button value=Back  name=back1 onclick=home()  style="font-family:arial; font-size: 12px ; background-color:white;color:blue;width:100px">
</td>   
    <td colspan=5 align=Center bgcolor=#ccffcc><font face=arial size=4>HALL TABLE ALLOCATION FOR COUNTING GROUP FOR LAC NO-<?php echo $lac;?></font></td>
<tr>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
SLNO
</td>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
HALL NO
</td>
<td align=center bgcolor="#FFFF33" WIDTH="10%"><font face=arial size=2>
TABLE NO
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
</tr>

<?php

$objMg->setCondString(" Lac=".$laccode." and Hall_no>0 and Table_no>0 order by Hall_no,Table_no");
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
<td align=center><font face=arial size=3>
<?php
echo ($ii+1);
?>
</td>
<td align=center><font face=arial size=3>
<?php echo $row[$ii]['Hall_no'];?>    
</td>   
<td align=center><font face=arial size=3>
<?php echo $row[$ii]['Table_no'];?>    
</td>  
<td align=center><font face=arial size=3>
<?php echo $row[$ii]['Grpno'];?>    
</td> 
<td align=left><font face=arial size=3>
<?php
$objPol->setSlno($row[$ii]['Sr']);
if($objPol->EditRecord())
{
$tvalue=$objPol->getName ()."</b>,".$objPol->getDesig ()."<br>";  
echo $tvalue;
}
?>
</td>
<td align=left><font face=arial size=3>
<?php
$objPol->setSlno($row[$ii]['Ast1']);
if($objPol->EditRecord())
{
$tvalue=$objPol->getName ()."</b>,".$objPol->getDesig ()."<br>";  
echo $tvalue;
}
?>
<td>    
</tr>
<?php
}
?>
<form name="newform" method="post" action="">
<tr><td colspan=5>
<input type="hidden" size="2" name="Lac" value="<?php echo $laccode;?>">
</td>
    <td align="center">
<input type="button" value="LOCK" name=l style="font-family:arial; font-size: 12px ;font-weight:bold; background-color:red;color:black;width:60px" onclick="lock()">    
</td></tr>
</form>
<?php
$t1= date('H:i:s');        
$tt=$tt.$objUtility->elapsedTimeMsg($t1, $t2);

//$mrow=$objUtility->elapsedTime($t1, $t2);
//if ($mrow['h']>0)
//$tt= $tt.$mrow['h']." Hours ";
//if ($mrow['m']>0)
//$tt= $tt.$mrow['m']." Minutes ";
//if ($mrow['s']>0)
//$tt= $tt.$mrow['s']." Second";
//$tt= $tt.")";

echo $objUtility->alert($tt);

?>
</table>
</body>
</html>
