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
require_once '../class/class.lac.php';
require_once '../class/class.category.php';
require_once '../class/class.Sentence.php';
require_once '../class/class.cell.php';
$objUtility=new Utility();
$objPoling=new Poling();
$Util=new myutility();

$objSen=new Sentence();

if (isset($_POST['id']))
$id=$_POST['id'];
else
$id=0;

if(!is_numeric($id))
$id=1;

if($id<0 || $id>5)
$id=0;

if (isset($_POST['Category']))
$cat=$_POST['Category'];
else
$cat=0;

if (isset($_POST['Cell']))
$cell=$_POST['Cell'];
else
$cell=0;

$objCell=new Cell();
$objCell->setCode($cell);
if($objCell->EditRecord() && $cell>0 && $cat==6)
{
$cellname="(".$objCell->getName ().")";
}
else
$cellname="";    

if($cell>0)
$cond=" deleted='N' and Pollcategory=".$cat." and Cellname=".$cell." and ";
else
$cond=" deleted='N' and Pollcategory=".$cat." and ";
    

$objCat=new Category();
$objCat->setCode($cat);
if ($objCat->EditRecord())
$catname=$objCat->getName ();
else
$catname="";

$head=strtoupper($catname)." OFFICER ".$cellname;

if ($id==0)
{    
$head=$head."  AVAILABLE ON DATABASE";
$cond=$cond." Sex='M'";
}

if ($id==1)
{    
$head=$head." SELECTED IN FINAL GROUP IN MAIN LIST";
$cond=$cond." Grpno>0 and Selected='Y'";
}

if ($id==2)
{
$head=$head." SELECTED AS RESERVE";
$cond=$cond." Grpno>0 and Selected='R'";
}
if ($id==3)
{
$head=$head." NOT SELECTED IN FINAL GROUP";
$cond=$cond." Grpno=0 and Selected='Y'";
}    

if ($id==4) //Not Selected in First Training
{
$head=$head." NOT SELECTED IN FIRST TRAINING";
$cond=$cond." Slno not in(select Poling_id from Poling_training where Phaseno=1)";
}

if ($id==5) // Selected in First Training
{
$head=$head." SELECTED IN FIRST PHASE TRAINING";
$cond=$cond." Slno  in(select Poling_id from Poling_training where Phaseno=1)";
}


if (isset($_POST['Sorton']))
$cond=$cond." order by ".$_POST['Sorton'];

if (isset($_POST['Asc']))
$cond=$cond."  ".$_POST['Asc'];

    
?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=100%>
<Thead>
<tr><td colspan=9 align=Center><hr></td></tr>
<tr><td colspan=9 align=Center bgcolor=#ccffcc><b><font face=arial size=3><?php echo $head;?></font></td></tr>
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
