<html>
<title>List of Gazeted  person</title>
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
function go()
{
window.location="../Mainmenu.php?tag=1";
}
</script>
<body>

<?php
session_start();
require_once '../class/utility.php';
require_once '../class/utility.class.php';
require_once '../class/class.poling.php';
require_once '../class/class.lac.php';
require_once '../class/class.category.php';
require_once '../class/class.Sentence.php';

$objUtility=new Utility();
$objPoling=new Poling();
$Util=new myutility();

$objSen=new Sentence();

if (isset($_GET['id']))
$id=$_GET['id'];
else
$id=0;




$objCat=new Category();


  
$head=" GAZETTED OFFICER LIST";
$cond=" Gazeted='Y' order by department,name";

   
?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=100%>
<Thead>
<tr><td colspan=8 align=Center><hr></td></tr>
<tr>
<td align="center">
<input type=button value="Back"  name=back onclick=go()  style="font-family:arial; font-size: 14px ; background-color:orchid;color:black;width:40px">
</td>    
<td colspan=7 align=Center bgcolor=#ccffcc><b><font face=arial size=3><?php echo $head;?></font></td>
</tr>
<tr>
<td align=center bgcolor="#3399FF" width="5%"><font face=arial size=2>
Sl No
</td>
<td align=center bgcolor="#3399FF" width="8%"><font face=arial size=2>
Poling ID
</td>
<td align=center bgcolor="#3399FF" width="35%"><font face=arial size=2> 
Name, Designation and Address
</td>
<td align=center bgcolor="#3399FF"  width="14%"><font face=arial size=2>
Home LAC
</td>
<td align=center bgcolor="#3399FF" width="10%"><font face=arial size=2 >
Basic Pay
</td>
<td align=center bgcolor="#3399FF" width="6%"><font face=arial size=2 >
Age
</td>
<td align=center bgcolor="#3399FF" width="11%"><font face=arial size=2 >
Retire Date
</td>
<td align=center bgcolor="#3399FF" width="12%"><font face=arial size=2 > 
Phone
</td>
</tr>
</Thead>

<?php
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
//echo $objPoling->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
$objCat->setCode($row[$ii]['Pollcategory']);
if ($objCat->EditRecord())
$catname=$objCat->getName ();
else
$catname="";    
?>
<tr>
<td align=center><font face=arial size=2>
<?php
echo ($ii+1);
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Slno'];
echo $tvalue;
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue="<b>".$row[$ii]['Name']."</b>,&nbsp;";
$tvalue=$tvalue.$row[$ii]['Desig']."<br>";
$tvalue=$tvalue.$row[$ii]['Department'];
$tvalue=$tvalue."<br>Address-".$row[$ii]['Placeofresidence'];
$tvalue=$tvalue."<br>Duty Category-".$catname;
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$objLac=new Lac();
$objLac->setCode($row[$ii]['Homeconst']);
$objLac->editRecord();
echo $row[$ii]['Homeconst']."-";
$tvalue=$objLac->getName();
echo $objSen->SentenceCase($tvalue);
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Basic'];
echo $Util->convert2standard($tvalue);
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Age'];
echo $tvalue;
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue=$objUtility->to_date($row[$ii]['Dor']);
echo $tvalue;
?>&nbsp;
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Phone'];
echo $tvalue;
?>&nbsp;
</td>
</tr>
<?php
}
?>
</table>

</body>
</html>
