<html>
<title>Display EVM Group</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="CreateEVMGroup.php?tag=0";
}

function validate(a)
{
var name = confirm("Lock EVM Pair?")
if (name == true)
window.location="lockevm.php?code="+a;
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
<tr><td colspan=7 align=Center bgcolor=#ccffcc><a href="CreateEvmGroup.php?tag=0"><font face=arial size=4>EVM PAIR FOR <?php echo $lacname;?></font></a></td></tr>
<tr>
<td align=center width="10%" rowspan="2" bgcolor=#ccffcc><font face=arial size=2>
<b>Serial No
</td>
<td align=center width="45%" colspan="3" bgcolor=#ccffcc><font face=arial size=2>
    <b>Control Unit Detail
</td>
<td align=center width="45%" colspan="3" bgcolor=#ccffcc><font face=arial size=2>
<b>Ballot Unit detail
</td>
</tr>
<tr>
<td align=center width="15%" bgcolor=#ccffcc><font face=arial size=2>
  <b>Current ID
</td>    
<td align=center width="10%" bgcolor=#ccffcc><font face=arial size=2>
  <b>Trunc No
</td>
<td align=center width="15%" bgcolor=#ccffcc><font face=arial size=2>
    <b>Unit Number
</td>
<td align=center width="15%" bgcolor=#ccffcc><font face=arial size=2>
  <b>Current ID
</td>    
<td align=center width="10%" bgcolor=#ccffcc><font face=arial size=2>
  <b>Trunc No
</td>
<td align=center width="15%" bgcolor=#ccffcc><font face=arial size=2>
    <b>Unit Number
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
$tvalue=$row[$ii]['Cu_id'];
echo $tvalue;
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
$tvalue=$row[$ii]['Bu_id'];
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
</tr>
<?php
}
?>
<tr>
<td align=center colspan="3">&nbsp;
<input type="button" name="back1" value="Back" onclick="home()" style="font-family:arial; font-size: 12px ; background-color:grey;color:black;width:90px">    
</td>
<td align=center colspan="4">
<input type="hidden" nam="lac" id="lac" value="<?php echo $code;?>" >   
<input type=button value="Lock"  name=Save onclick=validate("<?php echo $code;?>")  style="font-family:arial; font-size: 12px ; background-color:orange;color:black;width:90px">
</td>
</tr>
</table>
</body>
</html>
