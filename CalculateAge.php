<?php
session_start();
//$objU=new Utility();
if (isset($_POST['Dor']))
$dor=$_POST['Dor'];
else
$dor="0";

if (isset($_POST['Age']))
$age=$_POST['Age'];
else
$age="0";

$date2=substr($dor,-4);
$date1=date('Y');
//$date2=$objU->to_mysqldate($dor);
//$date1=date('Y-m-2');

//$diff=$objU->dateDiff($date2, $date1);
//$diff=round($diff/365);

if($age==0)
echo (58-($date2-$date1));
else
echo $age;    

?>
