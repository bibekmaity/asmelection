<?php
session_start();
require_once '../class/utility.class.php';

$objUtility=new Utility();

if (isset($_GET['Param']))
$Param=$_GET['Param'];
else
$Param="-1";

if (isset($_POST['Code']))
$code=$_POST['Code'];
else
$code="0";


if (isset($_POST['Deptype']))
$deptype=$_POST['Deptype'];
else
$deptype="0";

if($Param==1)
{
$n=strlen($code);
$sql="Select Designation from Designation where Dep_type='".$deptype."' and substring(Designation,1,".$n.")='".$code."' order by Designation limit 5";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
{
echo "[".$row['Designation']."] ";
}
}//$param==1

if($Param==2)
{
$sql="Select Designation from Designation where Dep_type='".$deptype."' and Designation='".$code."' order by Designation limit 1";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($row)
echo "Duplicate Data";
else
{
?>
<input type=button value=Save  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;width:100px">
<?php
echo "";
}
}//$param==1
?>
