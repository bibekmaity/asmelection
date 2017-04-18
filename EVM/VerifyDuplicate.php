<?php
session_start();
require_once '../class/utility.class.php';

$objUtility=new Utility();

if (isset($_POST['Code']))
$code=$_POST['Code'];
else
$code="0";

if(isset($_GET['Param']))
$Param=$_GET['Param'];
else
$Param=0;

if($Param=="B")
{
$sql="Select Bu_number from BU where Bu_number='".$code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($row)
echo $code." Already Available";
else
{
?>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
<?php
}
}

if($Param=="C")
{
$sql="Select Bu_number from BU where Bu_number='".$code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($row)
echo $code." Already Available";
else
{
?>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
<?php
}
}
?>
