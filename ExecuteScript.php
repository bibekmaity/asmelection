<html>
<head><title>Entry Form</title></head>
<BODY>
<?php 
require_once './class/utility.php';

$objUtility=new myutility();

header("Content-Type: text/html; charset=utf-8");
if(isset($_SESSION['catchmessage']))
{
$msg=$_SESSION['catchmessage'];
unset($_SESSION['catchmessage']);
}
else
$msg="";
echo "<p align=center>".$msg."</p>";



$success=0;
$failed=0;
$t2= date('H:i:s');
$filename = "./Database/BlankDatabase.sql";
$fp = fopen( $filename, "r" ) or die("Couldn't open $filename");
$str="";
while ( ! feof( $fp ) ) 
{
   $line = fgets( $fp, 1024 );
   $str=$str.$line;
}
 
$myrow=array();
$myrow=explode(";",$str);   //Segrigate the String into SQL Statement on Semicolon

for($i=0;$i<count($myrow)-1;$i++)
{
//echo $i.$myrow[$i].";<br>";
if (mysql_query($myrow[$i]))
$success++;
}

if ($success>0)
echo $objUtility->alert("Created   Table");

?>
<br>
<p align=center><a href="indexPage.php?tag=0">
<img src="./image/login.jpg" width=100 height=40>
</a></p>
</body></html>
