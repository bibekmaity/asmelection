<html>
<title>List of Poling person</title>
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
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.Sentence.php';
$objUtility=new Utility();
$objPoling=new Poling();

$objSen=new Sentence();

if (isset($_GET['dcode']))
$dcode=$_GET['dcode'];
else
$dcode=0;

$objPoling->setCondString(" deleted='N' and depcode=".$dcode." order by name");
$row=$objPoling->getAllRecord();
if(isset($row[0]['Department']))
$depname=$row[0]['Department'];
else
$depname="";

?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=100%>
<Thead>
<tr><td colspan=7 align=Center bgcolor=#ccffcc><font face=arial size=2 color=black><b><?php echo $depname?></font></td></tr>
<tr>
<td align=center width=6% bgcolor=#ccffcc><font face=arial size=2>
Slno
</td>
<td align=center width=9% bgcolor=#ccffcc><font face=arial size=2>
Poling ID
</td>
<td align=left width=22% bgcolor=#ccffcc><font face=arial size=2>
Name & Designation
</td>
<td align=center width=18% bgcolor=#ccffcc><font face=arial size=2>
Address
</td>
<td align=center width=10% bgcolor=#ccffcc><font face=arial size=2>
Basic Pay
</td>
<td align=center width=15% bgcolor=#ccffcc><font face=arial size=2>
Duty
</td>
<td align=center width=20% bgcolor=#ccffcc><font face=arial size=2>
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
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Slno'];
echo $tvalue;
?>
</td>
<td align=left><font face=arial size=2><b>
<?php
$tvalue=$objSen->SentenceCase($row[$ii]['Name']);
echo $tvalue."</b><br>";
$tvalue=$row[$ii]['Desig'];
echo $tvalue;
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue=$objSen->SentenceCase($row[$ii]['Placeofresidence']);
if(strlen($tvalue)>2)
echo $tvalue."<br>";
echo "Home Lac-";
$objLac=new Lac();
$objLac->setCode($row[$ii]['Homeconst']);
$objLac->editRecord();
$tvalue=$objLac->getName();
echo $objSen->SentenceCase($tvalue);
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Basic'];
echo $tvalue;
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
