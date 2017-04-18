<?php
session_start();
require_once './class/class.department.php';
require_once './class/class.poling.php';
require_once './class/utility.class.php';

if(isset($_GET['mval']))
$mval=$_GET['mval'];
else
$mval=-1;

$objU=new Utility();

if(isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if(isset($_POST['Deptype']))
$Deptype=$_POST['Deptype'];
else
$Deptype=0;

if(isset($_POST['Dname']))
$Dname=$_POST['Dname'];
else
$Dname="";
$objDepartment=new Department();
if($mtype==0 || $mtype==3)
{
if($mtype==0)
$cond="dep_type='".$Deptype."' and Department like '%".$Dname."%'"; //Change the condition for where clause accordingly
if($mtype==3)
{
if(strlen($Dname)>2)
$cond="Department like '%".$Dname."%'"; //Change the condition for where clause accordingly
else
$cond="1=2";
} //mtype==3

$objDepartment->setCondString($cond);

$row=$objDepartment->getRow();  
$mystyle="font-family: Arial;background-color:white;color:black;font-size: 12px;width:400px";
$row=$objDepartment->getRow();
?>
<select name="Editme" id="Editme" style="<?php echo $mystyle;?>" onchange="LoadTextBox()">
<?php $dval="0"; ?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind][0];
$mdetail=$row[$ind][1].",".$row[$ind][2];
if ($mval==$mcode)
$sel=" Selected ";
else
$sel=" ";
?>
<option <?php echo $sel;?> value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
} //for loop
?>
</select>
<?php
}

if($mtype==1)
{
$Depcode=$mval;
$objDepartment->setDepcode($Depcode);
if($objDepartment->EditRecord())
echo $objDepartment->getDepartment ();
//$objDepartment->r
$objPol=new Poling();
$avl=$objPol->rowCount("Depcode=".$Depcode);
echo "[Available Person-".$avl."]";
}

if($mtype==2)
{
$Depcode=$mval;
$objPol=new Poling();
$avl=$objPol->rowCount("Depcode=".$Depcode);
echo  $avl;
}

?>

 