<?php
session_start();
require_once './class/class.trg_hall.php';

if(isset($_POST['Venue']))
$vcode=$_POST['Venue'];
else
$vcode=0;

if(isset($_GET['type']))
$type=$_GET['type'];
else 
$type="";    

if($type=="H")
{
$objTrg_hall=new Trg_hall();    
$objTrg_hall->setCondString(" venue_code=".$vcode); //Change the condition for where clause accordingly
$row=$objTrg_hall->getRow();
?>
<select name="Hall_rsl" id="Hall_rsl" style="font-family: Arial;background-color:white;color:black; font-size: 12px" onchange="capacity()">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>&nbsp;
<?php
}//type=H


if($type=="C")
{
$objTrg_hall=new Trg_hall();    
if(isset($_POST['Hall']))
$hall=$_POST['Hall'];
else
$hall=0;
$objTrg_hall->setVenue_code($vcode);
$objTrg_hall->setRsl($hall);
if($objTrg_hall->EditRecord())
$capa= $objTrg_hall->getHall_capacity (); 
else 
$capa="";   
echo $capa;
?>
<?php
} //type=C

if($type=="D")
{
if(isset($_POST['Hall']))
$hall=$_POST['Hall'];
else
$hall=0;    
echo $vcode."-".$hall;
} //type=C

?>

