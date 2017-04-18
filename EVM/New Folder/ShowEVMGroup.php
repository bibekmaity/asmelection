<html>
<title>Display EVM Group</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="CreateEVMGroup.php?tag=0";
}
</script>
<body>

<?php
session_start();
require_once '../class/utility.class.php';
require_once './class/class.evmgroup.php';
require_once './class/class.cu.php';
require_once './class/class.bu.php';
require_once '../class/class.lac.php';

$objUtility=new Utility();

$roll=$objUtility->VerifyRoll();
if ($roll==-1 || $roll>2 )
header( 'Location: ../Mainmenu.php');

$objEvmgroup=new Evmgroup();
$objLac=new Lac();

if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if (!is_numeric($code))
$code=0;

$objLac->setCode($code);
if ($objLac->EditRecord())
$lacname=$code."-".strtoupper($objLac->getName());
else
$lacname="";    
?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=80%>
<tr><td colspan=6 align=Center bgcolor=#ccffcc><a href="CreateEvmGroup.php?tag=0"><font face=arial size=4>EVM PAIR FOR <?php echo $lacname;?></font></a></td></tr>
<tr>
<td align=center width="10%" rowspan="2" bgcolor=#ccffcc><font face=arial size=2>
Serial No
</td>
<td align=center width="35%" colspan="2" bgcolor=#ccffcc><font face=arial size=2>
Control Unit
</td>
<td align=center width="35%" colspan="2" bgcolor=#ccffcc><font face=arial size=2>
Ballot Unit 
</td>
<td align=center rowspan="2" width="20%" bgcolor=#ccffcc><font face=arial size=2>
Remarks
</td>
</tr>
<tr>
<td align=center width="15%" bgcolor=#ccffcc><font face=arial size=2>
  <b>Trunc No
</td>
<td align=center width="20%" bgcolor=#ccffcc><font face=arial size=2>
    <b>Unit No
</td>
<td align=center width="15%" bgcolor=#ccffcc><font face=arial size=2>
 <b>Trunc No
</td>
<td align=center width="20%" bgcolor=#ccffcc><font face=arial size=2>
 <b>Unit No
</td>
</tr>
<?php
$objEvmgroup->setCondString("lac=".$code." order by grpno");
$row=$objEvmgroup->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr>
<td align=center><font face=arial size=2>
<?php
//$tvalue=$row[$ii]['Grpno'];
echo $ii+1;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$objCu=new Cu();
$objCu->setCu_code($row[$ii]['Cu']);
$objCu->editRecord();
$tvalue=$objCu->getTrunck_number();
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$objCu->getCu_number();
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$objBu=new Bu();
$objBu->setBu_code($row[$ii]['Bu']);
$objBu->editRecord();
$tvalue=$objBu->getTrunck_number();
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$objBu->getBu_number();
echo $tvalue;
?>
</td>

<td align=center><font face=arial size=2>
<?php
if ($row[$ii]['Reserve']=="Y")
echo "Reserve";
else
echo "&nbsp;"
?>
</td>
</tr>
<?php
}
?>
<tr>
<td align=center colspan="3">&nbsp;
<input type="button" name="back1" value="Back" onclick="home()">    
</td>
<td align=center colspan="3">
<a href="lockevm.php?code=<?php echo $code;?>"><image src=../lock.ico width=15 height=20>lock</a>    
</td>
</tr>
</table>
</body>
</html>
