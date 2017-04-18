<html>
<title>Randomise EVM Station</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="Select4RandomiseEVM.php?tag=1";
}

function validate(a)
{
var name = confirm("Lock EVM Pair?")
if (name == true)
window.location="lockevmgroup.php?code="+a;
}

</script>
<body>


<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.lac.php';
require_once '../class/class.psname.php';
require_once '../class/class.final.php';
require_once './class/class.evmgroup.php';
require_once './class/class.cu.php';
require_once './class/class.bu.php';

$objPS=new Psname();
$objCU=new Cu();
$objBU=new Bu();

$objEvm=new Evmgroup();
$objUtility=new Utility();

//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$tt="";
$t2= date('H:i:s');

if (isset($_POST['lac']))
$lac=$_POST['lac'];
else
header('Loaction:index.php');

$laccode=$lac;

$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("4");

//if (isset($_POST['lockme']))
//{    
//$objF->setLocked ("Y");
//$objF->SaveRecord();
//}

if ($objF->EditRecord())
{
$fin="Final List";
$lock=true;
}
else
{
$lock=false;
$fin="";
//Randomise Table
$pscount=$objPS->rowCount("Lac=".$laccode);
$objEvm->RandomiseEVM($laccode,$pscount);
}


$objLac=new Lac();
$objLac->setCode($lac);
$objLac->editRecord();
$lac=$lac."-".$objLac->getName();

?>



<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=90%>
<Thead>
<tr><td colspan=6 align=Center bgcolor=#ccffcc><font face=arial size=4><?php echo $fin;?> EVM Pair with Poling Station No. LAC-<?php echo $lac;?></font></td>
<td>
<input type=button value=Back  name=back1 onclick=home()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
   
</td>
</tr>
<tr>
<td align=center width="6%" rowspan="2"><font face=arial size=3>
SlNo
</td>
<td align=center width="8%" rowspan="2"><font face=arial size=3>
PS No
</td>
<td align=center width="30%" rowspan="2"><font face=arial size=3>
Poling Station Name
</td>
<td align=center width="27%" colspan="2"><font face=arial size=3>
Control Unit
</td>
<td align=center width="27%" colspan="2"><font face=arial size=3>
Ballot Unit
</td>
</tr>
<tr>
<td align=center width="13%" ><font face=arial size=3>
Current ID
</td>
<td align=center width="12%" ><font face=arial size=3>
Unit Number
</td>
<td align=center width="13%" ><font face=arial size=3>
Current ID
</td>
<td align=center width="12%" ><font face=arial size=3>
Unit Number
</td>
</tr>

<?php
$objEvm->setCondString("Lac=".$laccode." order by Reserve,Psno");
$row=$objEvm->getAllRecord();
//echo $objPsname->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr>
<td align=center><font face=arial size=2>
<?php
echo ($ii+1);
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Psno'];
if($tvalue>0)
echo $tvalue;
else
echo "R";
?>
</td>
<td align=left><font face=arial size=2>
<?php
$objPS->setLac($laccode);
$objPS->setPsno($tvalue);
if ($objPS->EditRecord())
$tvalue=$objPS->getPsname ();
else
$tvalue="Reserve";
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
echo $row[$ii]['Cu_id'];
?>
</td>
<td align=center><font face=arial size=2>
<?php
$objCU->setCu_code($row[$ii]['Cu']);
if ($objCU->EditRecord())
$tvalue=$objCU->getCu_number ();
else 
$tvalue="";    
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
echo $row[$ii]['Bu_id'];
?>
</td>
<td align=center><font face=arial size=2>
<?php
$objBU->setBu_code($row[$ii]['Bu']);
if ($objBU->EditRecord())
$tvalue=$objBU->getBu_number ();
else 
$tvalue="";    
echo $tvalue;
?>
</td>
</tr>
<?php
}

$tt=$tt."(Query took ";
$t1= date('H:i:s');
$mrow=$objUtility->elapsedTime($t1, $t2);
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Minutes ";
//if ($mrow['s']>0)
$tt= $tt.$mrow['s']." Second";
$tt= $tt.")";

echo $objUtility->alert($tt);
if($lock==false)
{
?>

<tr><td colspan=5>&nbsp;</td><td align=center colspan=2>
<input type=button value="Lock"  name=Save onclick=validate("<?php echo $laccode;?>")  style="font-family:arial; font-size: 12px ; background-color:orange;color:black;width:90px">
</td></tr>
<?php
}
?>
</table>
</body>
</html>
