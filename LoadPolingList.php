
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';

$objUtility=new Utility();
$objPoling=new Poling();


if(isset($_POST['Type']))
$Type=$_POST['Type'];
else
$Type=0;

if(isset($_POST['Slno']))
$Slno=$_POST['Slno'];
else
$Slno=0;

if(isset($_POST['Cat']))
$Cat=$_POST['Cat'];
else
$Cat=0;

if(isset($_POST['Depcode']))
$Depcode=$_POST['Depcode'];
else
$Depcode=0;

if(isset($_POST['Samedep']))
$Samedep=1;
else
$Samedep=0;
?>

<table border="1" width="100%" align="center" style=border-collapse: collapse; width=95%>
<tr><td align="center" bgcolor="#FFCC66" width="7%"><font size="2" face=arial align="center">SlNo</td>
<td align="center" bgcolor="#FFCC66" width="10%"><font size="2" face=arial >Poling ID</td>    
<td align="center" bgcolor="#FFCC66" width="65%"><font size="2" face=arial >Name and Address</td>
<td align="center" bgcolor="#FFCC66" width="15%"><font size="2" face=arial>Training</td>
<td align="center" bgcolor="#FFCC66" width="10%"><font size="2" face=arial>Select</td>
</tr>   
<?php 

if($Type==2) //Replacement after Grouping
{
if($Samedep==0)
$cond=" (Selected='Y' )and Grpno=0 and Pollcategory=".$Cat." order by rnumber";

if($Samedep==1)
$cond=" (Selected='Y' )and Grpno=0 and Pollcategory=".$Cat." and Depcode=".$Depcode." order by rnumber";
}

if($Type==1) //Replacement after Training
{
$mycond=" and Slno not in(Select Poling_id from Poling_training where Phaseno=1)" ;  
if($Samedep==0)
$cond=" (Selected='Y' )and Grpno=0 and Pollcategory=".$Cat.$mycond." order by rnumber";

if($Samedep==1)
$cond=" (Selected='Y' )and Grpno=0 and Pollcategory=".$Cat.$mycond." and Depcode=".$Depcode." order by rnumber";
}


$objPoling->setCondstring($cond);
$row=$objPoling->getSelectedRow(10);
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr><td align=center><font size="2" face=arial>
<?php echo $ii+1;?>
</td>
<td align=center><font size="2" face=arial>
<?php echo $row[$ii]['Slno'];?>
</td>
<td align=left><font size="2" face=arial>
<?php echo $row[$ii]['Name'].",<font color=grey>".$row[$ii]['Desig'];?>
<br>
<font size="1" face=arial>
<?php echo $row[$ii]['Department'];?>    
</td>
<td align="center"><font size="2" face=arial>
<?php 
if($objPoling->isPresentinTraining($row[$ii]['Slno'],1))
echo "Done";
else
echo "Not Done";    
?>

</td>
<td align="center">
<input type=radio Name="Idno" value="<?php echo $row[$ii]['Slno'];?>" onclick="place(<?php echo $row[$ii]['Slno'];?>)">
</td>
</tr>
<?php 
$rno=rand(1,100000);
$sql="update poling set rnumber=".$rno." where Slno=".$row[$ii]['Slno'];
$objPoling->ExecuteQuery($sql);
}//for Loop
?>
</table>

    
