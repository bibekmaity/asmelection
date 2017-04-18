<?php
session_start();
require_once '../class/utility.class.php';

$objUtility=new Utility();

if (isset($_POST['Id']))
$id=$_POST['Id'];
else
$id=0;

if (isset($_POST['Cat']))
$code=$_POST['Cat'];
else
$code="0";

if (isset($_POST['Cell']))
$cell=$_POST['Cell'];
else
$cell=0;

if($cell>0)
$cond=" deleted='N' and Pollcategory=".$code." and Cellname=".$cell." and ";
else
$cond=" deleted='N' and Pollcategory=".$code." and ";
  

if($id==-1)
$cond=$cond." 1=2";

if ($id==0)
$cond=$cond." Sex='M'";


if ($id==1)
$cond=$cond." Grpno>0 and Selected='Y'";


if ($id==2)
$cond=$cond." Grpno>0 and Selected='R'";

if ($id==3)
$cond=$cond." Grpno=0 and Selected='Y'";
    

if ($id==4) //Not Selected in First Training
$cond=$cond." Slno not in(select Poling_id from Poling_training where Phaseno=1)";

if ($id==5) // Selected in First Training
$cond=$cond." Slno  in(select Poling_id from Poling_training where Phaseno=1)";


$sql="Select count(*) from Poling where ".$cond;

$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($code>0 && $id>=0)
echo "Available- <b>".$row[0]."</b>";

?>
