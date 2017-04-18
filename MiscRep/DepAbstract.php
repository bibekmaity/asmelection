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
require_once '../class/utility.php';
require_once '../class/utility.class.php';
require_once '../class/class.poling.php';
require_once '../class/class.department.php';
require_once '../class/class.lac.php';
require_once '../class/class.category.php';
require_once '../class/class.Sentence.php';
require_once '../class/class.Deptype.php';

$objUtility=new Utility();
$objPoling=new Poling();
$Util=new myutility();

$objSen=new Sentence();

if (isset($_POST['id']))
$id=$_POST['id'];
else
$id=1;

if(!is_numeric($id))
$id=1;

if($id==0 || $id>2)
$id=1;


if (isset($_POST['Category']))
$cat=$_POST['Category'];
else
$cat=0;


$objCat=new Deptype();
$objCat->setCode($cat);
if ($objCat->EditRecord())
$catname=$objCat->getName ();
else
$catname="";

$head=$catname." LIST";

if ($id==1)
{    
$head=$head." WITH SUMMARY OF ALL PERSON";    
$mcond=" Deleted='N'";
}

if ($id==2)
{
$head=$head." WITH SUMMARY OF ALL SELECTED PERSON IN POLING GROUP";
$mcond=" Grpno>0";
}

    
?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=100%>
<Thead>
<tr><td colspan=9 align=Center><hr></td></tr>
<tr><td colspan=9 align=Center bgcolor=#ccffcc><b><font face=arial size=3><?php echo $head;?></font></td></tr>
<tr>
<td align=center bgcolor="#6699CC" width="6%"><font face=arial size=2>
Sl No
</td>
<td align=center bgcolor="#6699CC" width="30%"><font face=arial size=2> 
Name of Office
</td>
<td align=center bgcolor="#6699CC"  width="9%"><font face=arial size=2>
Presiding
</td>
<td align=center bgcolor="#6699CC" width="9%"><font face=arial size=2 >
First Poling
</td>
<td align=center bgcolor="#6699CC" width="9%"><font face=arial size=2 >
Second Poling
</td>
<td align=center bgcolor="#6699CC" width="9%"><font face=arial size=2 >
Third Poling
</td>
<td align=center bgcolor="#6699CC" width="9%"><font face=arial size=2 > 
Forth Poling
</td>
<td align=center bgcolor="#6699CC" width="9%"><font face=arial size=2 > 
Other Category
</td>
<td align=center bgcolor="#6699CC" width="10%"><font face=arial size=2 > 
Total
</td>
</tr>
</Thead>

<?php
$objDep=new Department();
$str=" Dep_type='".$cat."' order by Beeo_code,Department";
$objDep->setCondString($str);
$row=$objDep->getAllRecord();
//echo $objPoling->returnSql;
$gtot=array();
for($i=1;$i<=7;$i++)
$gtot[$i]=0;
$objBo=new beeo();
for($ii=0;$ii<count($row);$ii++)
{
$tot=0;


$objBo->setCode($row[$ii]['Beeo_code']);
if ($objBo->EditRecord() && $row[$ii]['Beeo_code']>0)
$addr=",C/o BEEO ".$objBo->getName();
else
$addr=",".$row[$ii]['Address'];


?>
<tr>
<td align=center><font face=arial size=2>
<?php
echo ($ii+1);
$dcode=$row[$ii]['Depcode'];
$cond=$mcond." and Depcode=".$dcode;
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Department'].$addr;
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$condition=$cond." and Pollcategory=1";
$tvalue=$objPoling->rowCount($condition);
echo $tvalue;
$tot=$tot+$tvalue;
$gtot[1]=$gtot[1]+$tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$condition=$cond." and Pollcategory=2";
$tvalue=$objPoling->rowCount($condition);
echo $tvalue;
$tot=$tot+$tvalue;
$gtot[2]=$gtot[2]+$tvalue;
?>
</td>    
<td align=center><font face=arial size=2>
<?php
$condition=$cond." and Pollcategory=3";
$tvalue=$objPoling->rowCount($condition);
echo $tvalue;
$tot=$tot+$tvalue;
$gtot[3]=$gtot[3]+$tvalue;
?>
</td> 
<td align=center><font face=arial size=2>
<?php
$condition=$cond." and Pollcategory=4";
$tvalue=$objPoling->rowCount($condition);
echo $tvalue;
$tot=$tot+$tvalue;
$gtot[4]=$gtot[4]+$tvalue;
?>
</td> 
<td align=center><font face=arial size=2>
<?php
$condition=$cond." and Pollcategory=5";
$tvalue=$objPoling->rowCount($condition);
echo $tvalue;
$tot=$tot+$tvalue;
$gtot[5]=$gtot[5]+$tvalue;
?>
</td> 
<td align=center><font face=arial size=2>
<?php
$condition=$cond." and Pollcategory not in(1,2,3,4,5)";
$tvalue=$objPoling->rowCount($condition);
echo $tvalue;
$tot=$tot+$tvalue;
$gtot[6]=$gtot[6]+$tvalue;
?>
</td> 
<td align=center><font face=arial size=2><b>
<?php
echo $tot;
$gtot[7]=$gtot[7]+$tot;
?></b>
</td> 
</tr>
<?php
}
?>
<tr>
<td align=right colspan="2" bgcolor="#6699CC"><font face=arial size=2>TOTAL</TD>
<?php 
for($i=1;$i<=7;$i++)
{
?>
<td align=center bgcolor="#6699CC"><font face=arial size=2><b>
<?php
echo $gtot[$i];
?></b>
</td>
<?php
}
?>

</tr>
</table>

</body>
</html>
