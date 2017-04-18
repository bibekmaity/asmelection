<?php
session_start();
require_once './class/utility.class.php';
$objUtility=new Utility();

if (isset($_POST['Lac']))
$lac=$_POST['Lac'];
else
$lac=0;

$laccode=$lac;

$objUtility->saveSqlLog("RAN", $lac);

$boxname="Day".$laccode."_0";

if(isset($_POST[$boxname]))
$Code1=1;
else
$Code1=0;    

$objUtility->saveSqlLog("RAN", "Code1=".$Code1);

$boxname="Day".$laccode."_1";

if(isset($_POST[$boxname]))
$Code2=1;     
else
$Code2=0; 
$objUtility->saveSqlLog("RAN", "Code2=".$Code2);


if(($Code1==1 || $Code2==1) && $lac>0)
echo $Code1+$Code2+$lac;
else
echo "0";    
?>
