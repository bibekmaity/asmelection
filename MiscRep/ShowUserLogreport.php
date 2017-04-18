<?php 
require_once 'MiscMenuHead.html';
date_default_timezone_set("Asia/kolkata");

?>
<script language=javascript>
<!--
function home()
{
window.location="mainmenu.php?tag=1";
}

function clearlog(a)
{
window.location="clearlog.php?uid="+a;
}
</script>

<body>
 <?php
header('Refresh: 90;url=ShowUserlogreport.php');
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.userlog.php';
require_once '../class/class.pwd.php';
$objUtility=new Utility();
$objPwd=new Pwd();

//Start Verify
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objUserlog=new Userlog();
//$objUserlog->setCondstring("Log_date='".."' order by Uid");

if(isset($_POST['Mydate']))
{
$mydate1=$_POST['Mydate'];
$mydate=$objUtility->to_mysqldate($mydate1);
}
else
{
$mydate=date('Y-m-d');    
$mydate1=date('d/m/Y');   
}
$status="";

 ?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=90%>
<Thead>
<tr><td colspan=7 align=Center bgcolor="white"><font face=arial size=3>Daily Log Detail on:&nbsp;<?php echo $mydate1;?></font></td></tr>
<tr>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
User Name
</td>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
Serial
</td>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
Log in Time
</td>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
Log out Time
</td>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
Machine IP
</td>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
DURATION
</td>
<td align=center bgcolor="#99CCFF">    <font face="arial" size="2" color="black">  
Status
</td>
</tr>
</Thead>
<?php
$objPwd->setCondString("Uid in (Select Uid from Userlog where Log_date='".$mydate."')");
$row=$objPwd->getAllRecord();
//echo $objPwd->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
//if($objUserlog->isActiveUser($row[$ii]['Uid'],6))
if($objUserlog->isActive($row[$ii]['Uid']))        
{    
$status="ACTIVE" ;
$bgcol="#99FF66";
}
else
{
$status="LOG OUT" ;   
$bgcol="white";
}

$objUserlog->setCondString("Log_date='".$mydate."' and Uid='".$row[$ii]['Uid']."' order by session_id"); 
$mrow=$objUserlog->getAllRecord();  
$rspan=count($mrow);
for($ind=0;$ind<count($mrow);$ind++)
{
if($ind==(count($mrow)-1))
$mcol=$bgcol;
else
{
if($status=="ACTIVE")
$mcol="grey";
else
$mcol="white";   
}
$t2=$mrow[$ind]['Log_time_in'];
$ampm=substr($t2,-2);
if($ampm=="PM")
{
$h=substr($t2,0,2)+12;
$t2=$h.":".substr($t2,3,5);
} //ampm=pm
else
$t2=substr($t2,0,8);

$t1=$mrow[$ind]['Log_time_out'];
if(strlen($t1>0))
{
$ampm=substr($t1,-2);
if($ampm=="PM")
{
$h=substr($t1,0,2)+12;
$t1=$h.":".substr($t1,3,5);
} //ampm=pm
else
$t1=substr($t1,0,8);
}
else
$t1=$t2;
$duration=$objUtility->elapsedTimeMsg($t1,$t2)

?>
<tr>
<?php if ($ind==0){?>
<td align=left rowspan="<?php echo $rspan;?>" bgcolor="white">
    <font face="arial" size="2" color="black">    
<?php
$tvalue=$row[$ii]['Fullname'];
echo $tvalue;
?>
</td>
<?php }?>
<td align=center bgcolor="<?php echo $mcol;?>"> <font face="arial" size="2" color="black"> 
<?php
echo ($ind+1);
?>    
</td>
<td align=center bgcolor="<?php echo $mcol;?>">    <font face="arial" size="2" color="black">  
<?php
$tvalue=$mrow[$ind]['Log_time_in'];
echo $tvalue;
?>
</td>
<td align=center bgcolor="<?php echo $mcol;?>">    <font face="arial" size="2" color="black">  
<?php
$tvalue=$mrow[$ind]['Log_time_out'];
echo $tvalue;
?>
</td>
<td align=left bgcolor="<?php echo $mcol;?>">    <font face="arial" size="2" color="black">  
<?php
$tvalue=$mrow[$ind]['Client_ip'];
echo $tvalue;
?>
</td>
<td align=left bgcolor="<?php echo $mcol;?>">    <font face="arial" size="2" color="black">  
<?php
echo $duration;
?>
</td>
<?php if ($ind==0){?>
<td align=center rowspan="<?php echo $rspan;?>" bgcolor="white">
<font face="arial" size="1" color="black">  
<?php
echo $status."<br>";
//echo $roll.">=".$row[$ii]['Roll'];
if ($status=="ACTIVE" && $roll<=$row[$ii]['Roll'] && $roll<3)
{
?>
<input type=button name=clr id="clr" value="Force Logout" onclick=clearlog("<?php echo $row[$ii]['Uid'];?>")>
<?php
}
?>
</td>
<?php }?>
</tr>
<?php
}//for $ind
}//for $ii
?>
</table>

</body>
</html>
