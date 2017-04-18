<html>
<title>Checklist Poling person</title>
<HEAD>
  <STYLE type="text/css">
	@media screen{
		thead{display:table-header-group}
		}
	@media print{
		thead{display:table-header-group}
		body{margin-top:0.5 cm;margin-left:1.5 cm;margin-right:1 cm;margin-bottom:1}
		tfoot{display:none}
	}  
	
  </STYLE>
</HEAD>


<script language=javascript>
<!--
function home()
{
window.location="mainmenu.php?tag=1";
}
</script>
<body>

<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/utility.php';


$objU=new myutility();
$objUtility=new Utility();
$objPoling=new Poling();

$objSen=new Sentence();

if (isset($_GET['dcode']))
$dcode=$_GET['dcode'];
else
$dcode=0;


if (isset($_SESSION['uid']))
$uid=$_SESSION['uid'];
else
$uid="0";

$objP=new Pwd();
$objP->setUid($uid);
if($objP->EditRecord())
$uname=$objP->getFullname ();   
else
$uname="";

$cond="Slno in(Select distinct Pid from Poling_history where Rsl=1 and User_name='".$uid."' and E_date='".date('Y-m-d')."')";
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
//echo $objPoling->returnSql;
$header="Data Entered by ".$uname." on ".date('d/m/Y');
?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=100%>
<Thead>
<tr><td colspan=7 align=Center bgcolor=#ccffcc><font face=arial size=2 color=black><?php echo $header;?><b></font></td></tr>
<tr>
<td align=center width=6% bgcolor=#ccffcc><font face=arial size=2>
Slno
</td>
<td align=center width=15% bgcolor=#ccffcc><font face=arial size=2>
Office Name
</td>
<td align=left width=22% bgcolor=#ccffcc><font face=arial size=2>
Name & Designation
</td>
<td align=center width=9% bgcolor=#ccffcc><font face=arial size=2>
Poling ID (Note Down)
</td>
<td align=center width=10% bgcolor=#ccffcc><font face=arial size=2>
Basic Pay
</td>
<td align=center width=15% bgcolor=#ccffcc><font face=arial size=2>
Duty
</td>
<td align=center width=23% bgcolor=#ccffcc><font face=arial size=2>
Phone & Remarks
</td>
</tr>
</Thead>

<?php
$rc=0;
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr>
<td align=center><font face=arial size=2>
<?php
echo ($ii+1);
$rc++;
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Department'];
echo $tvalue;
?>
</td>
<td align=left><font face=arial size=2><b>
<?php
$tvalue=$objSen->SentenceCase($row[$ii]['Name']);
echo $tvalue."</b><br>";
$tvalue=$row[$ii]['Desig'];
echo $tvalue;
$tvalue=$objSen->SentenceCase($row[$ii]['Placeofresidence']);
if(strlen($tvalue)>2)
echo "<BR>".$tvalue;
?>
</td>
<td align=center><font face=arial size=2 color="orange"><b>
<?php
$tvalue=$row[$ii]['Slno'];
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Basic'];
echo $objU->convert2standard($tvalue);
?>
</td>
<td align=center><font face=arial size=2>
<?php
$objCategory=new Category();
$objCategory->setCode($row[$ii]['Pollcategory']);
$objCategory->editRecord();
$tvalue=$objCategory->getName();
echo $tvalue;
?>
</td>
<td><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Phone'];
if(strlen($tvalue)>=10)
echo "<div align=center>".$tvalue."</div>";
$tvalue=$row[$ii]['Remarks'];
if(strlen($tvalue)>1)
echo "<div align=justify>".$tvalue."</div>";
?>&nbsp;
</td>
</tr>
<?php
} //for LOOP
?>
</table>

</body>
</html>
