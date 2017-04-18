
<?php
//session_start();
header("Content-Type: text/html; charset=utf-8");
require_once 'menuhead.html';
require_once './class/utility.class.php';
$row=array();
$row[1]="Jayanta";
$row[2]="kamal";
$row[4]="harmej";
$row[8]="aditya thakur";
$row[10]="sunil dutta";

//Pregamatch

   

$objUtility=new Utility();
//echo $objUtility->dateDiff("1970-11-5","1970-10-26");
echo "<br>";

for($i=1;$i<=10000000;$i++)
{
$j=1;
}


for($i=1;$i<=10;$i++)
{
//echo $i.".".date('d-m-Y:H:i:s')."<br>";
echo date('H:i:s') ;
if (isset($row[$i]))
echo "Row".$i."=".$row[$i]." Random-".rand(1,10000)."<br>";
else
echo "Row".$i."=Not Available<br>";    
}
$objU=new Utility();
$b="06:28:22";
$a=date('H:i:s') ;
echo "diff-".$objU->elapsedTime($a,$b);
echo "<br>";
//date.timezone="Asia/kolkata";
date_default_timezone_set("Asia/kolkata");
echo date('h:i:s A');
?>
</body></html>
