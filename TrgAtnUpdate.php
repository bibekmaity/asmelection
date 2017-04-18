<html>
<head>
<title></title>
</head>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
$(":disabled").hide();  //Hide All Disabled item
});//End document ready
</script>

<script language=javascript>
<!--
function home()
{
window.location="trgAtn.php?tag=0";
}


</script>
<BODY>
<script language=javascript>
<!--
</script>
<body onload=setMe()>
<?php
session_start();
require_once './class/class.poling_training.php';
require_once './class/utility.class.php';
require_once './class/class.training.php';
require_once './class/class.trg_hall.php';
require_once './class/class.trg_time.php';
require_once './class/class.poling.php';
$objUtility=new Utility();
if ($objUtility->VerifyRoll()==-1)
header( 'Location: index.php');

$objPoling_training=new Poling_training();
if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;

if ($code==0) //Initial Loading
{
$sql="";
if (isset($_POST['Phaseno']))
{    
$sql=$sql."Phaseno=".$_POST['Phaseno'];
$_SESSION['Phaseno']=$_POST['Phaseno'];
}
else
{    
$sql=$sql."Phaseno=0"; 
$_SESSION['Phaseno']=0;
}
$sql=$sql." and ";
if (isset($_POST['Groupno']))
{
$sql=$sql."Groupno=".$_POST['Groupno'];
$_SESSION['Groupno']=$_POST['Groupno'];
}
else
{
$sql=$sql."Groupno=0"; 
$_SESSION['Groupno']=0;
}
//retrive Training Details
$objTrg=new Training();
$objTrg->setPhaseno($_SESSION['Phaseno']);
$objTrg->setGroupno($_SESSION['Groupno']);
if ($objTrg->EditRecord())
{
$venucode=$objTrg->getVenue_code();
$venue=$objTrg->getTrgplace();
$d1=$objTrg->getTrgdate1();
$d2=$objTrg->getTrgdate2();
$d3=$objTrg->getTrgdate3();
$maxday=Calculate($d1,$d2,$d3);
$timecode=$objTrg->getTrgtime();
$hallcode=$objTrg->getHall_rsl();
$objTime=new Trg_time();
$objHall=new Trg_hall();
$objTime->setCode($timecode);
$objHall->setVenue_code($venucode);
$objHall->setRsl($hallcode);
if ($objTime->EditRecord())
$timecode=$objTime->getTiming ();
else 
$timecode="";
if ($objHall->EditRecord())
$hallcode=$objHall->getHall_number ();
else
$hallcode="";    
}
else
header( 'Location: TrgAtn.php');    //return Back 

if (strlen($d1>0))
$_SESSION['d1']=1;
else
$_SESSION['d1']=0;

if (strlen($d2>0))
$_SESSION['d2']=1;
else
$_SESSION['d2']=0;

if (strlen($d3>0))
$_SESSION['d3']=1;
else
$_SESSION['d3']=0;



?>
<form name=myform action=TrgAtnUpdate.php?tag=2  method=POST >
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<tr>
<td align=center bgcolor=#99FFCC width=15%>
<input type=button value="Back"  name=back1 onclick=home()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:grey;color:black;width:80px" >
</td>
<td align=center bgcolor=#99FFCC width=93%><font size=2 face=arial color=blue>
Phase No-<?php echo $_POST['Phaseno'];?> Group No-<?php echo $_POST['Groupno'];?>
<BR>
<b><font color=red><?php echo $venue;?></b><font color=blue>&nbsp;&nbsp;Hall No-<b><font color=red><?php echo $hallcode;?></b>&nbsp;&nbsp;<font color=blue>From&nbsp;<font color=red><?php echo $timecode;?>
</td>
</tr>
</table>
<div align=center><font size=1 face=arial color=blue>
Uncheck the Respective Box against the absent Poling Officer. Otherwise He will be considered as Present.
</div>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<tr>
<td align=center bgcolor=#CCFFCC width="7%"><font size=2 face=arial color=black>
SlNo
</td>
<td align=center bgcolor=#CCFFCC width="8%"><font size=2 face=arial color=black>
Poling ID
</td>
<td align=center bgcolor=#CCFFCC width="55%"><font size=2 face=arial color=black>
Name & Designation of Trainee
</td>
<?php if($maxday>=1) { ?>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=black>
<?php echo $d1?>
</td>
<?php }?>
<?php if($maxday>=2) { ?>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=black>
<?php echo $d2?>
</td>
<?php }?>
<?php if($maxday>=3) { ?>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=black>
<?php echo $d3?>
</td>
<?php }?>
</tr>
<?php
$rowcount=0;
$objPoling_training->setCondString($sql);
$row=$objPoling_training->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$rowcount++;
$pid=$row[$ii]['Poling_id'];

if(strlen($row[$ii]['Attended1'])>0)
{
if ($row[$ii]['Attended1']=="Y")
$check1="  checked=checked";
else
$check1="";
}
else
$check1=" disabled";

if(strlen($row[$ii]['Attended2'])>0)
{
if ($row[$ii]['Attended2']=="Y")
$check2="  checked=checked";
else
$check2="";
}
else
$check2=" disabled";

if(strlen($row[$ii]['Attended3'])>0)
{
if ($row[$ii]['Attended3']=="Y")
$check3="  checked=checked";
else
$check3="";
}
else
$check3=" disabled";
?>
<tr>
<td align=center><font size=2 face=arial>
<?php
echo $ii+1;
?>
</td>
<td align=center><font size=2 face=arial>
<?php
echo $pid;
?>
</td>
<td align=left><font size=2 face=arial color=black><b>
<?php  
$Poling_id="Poling_id".$rowcount; 
$Upd="Upd".$rowcount;
$objPoling= new Poling();
$objPoling->setSlno($pid);
if($objPoling->EditRecord())
echo $objPoling->getName()."</b>,<font size=2 face=arial color=grey>".$objPoling->getDesig()."<br>".$objPoling->getDepartment();    

?>
<input type=hidden size=2 name="<?php echo $Poling_id;?>"  value="<?php echo $pid;?>" readonly>
</td>
<?php  $Attended1="Attended1".$rowcount; ?>
<?php if($maxday>=1) { ?>
<td align=center>
<input type=checkbox name="<?php echo $Attended1;?>"   id="<?php echo $Attended1;?>" <?php echo $check1;?> style="font-family: Arial;background-color:#CCFFFF;color:black;font-size: 12px" >
</td>
<?php } ?>
<?php  $Attended2="Attended2".$rowcount; ?>
<?php if($maxday>=2) { ?>
<td align=center>
<input type=checkbox name="<?php echo $Attended2;?>" id="<?php echo $Attended2;?>" <?php echo $check2;?> style="font-family: Arial;background-color:#CCFFFF;color:black;font-size: 12px" >
</td>
<?php } ?>
<?php  $Attended3="Attended3".$rowcount; 
 ?>
<?php if($maxday>=3) { ?>
<td align=center>
<input type=checkbox name="<?php echo $Attended3;?>" id="<?php echo $Attended3;?>" <?php echo $check3;?> style="font-family: Arial;background-color:#CCFFFF;color:black;font-size: 12px" >
</td>
<?php } ?>
</tr>
<?php
} //while
$_SESSION['rowcount']=$rowcount;
?>
<tr><td align=center bgcolor=#CCFFCC colspan=2 width=15%>
<input type=button value="Back"  name=back11 onclick=home()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:grey;color:black;width:80px" >
</td><td align=center bgcolor=#CCFFCC colspan="<?php echo $maxday+1;?>">
<input type=submit value="Update Attendance"  name=Save1 style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:220px">
</td></tr>
</table>
<?php
}//$code==1
if ($code==2) //PostBack Submit
{
$objTp=new Poling_training();
$objTp->setPhaseno($_SESSION['Phaseno']);
$objTp->setGroupno($_SESSION['Groupno']);
$upd=0;
//echo $_SESSION['rowcount'];
for ($ind=1;$ind<=$_SESSION['rowcount'];$ind++)
{
$Poling_id="Poling_id".$ind;
$Poling_id=$_POST[$Poling_id];
$objTp->setPoling_id($Poling_id);

if ($_SESSION['d1']==1)
{    
$Attended1="Attended1".$ind;
if (isset($_POST[$Attended1]))
$objTp->setAttended1 ("Y");
else
$objTp->setAttended1 ("N");
}
else
$objTp->setAttended1("NULL");

if ($_SESSION['d2']==1)
{    
$Attended2="Attended2".$ind;
if (isset($_POST[$Attended2]))
$objTp->setAttended2 ("Y");
else
$objTp->setAttended2 ("N");
}
else
$objTp->setAttended2("NULL");

if ($_SESSION['d3']==1)
{    
$Attended3="Attended3".$ind;
if (isset($_POST[$Attended3]))
$objTp->setAttended3 ("Y");
else
$objTp->setAttended3 ("N");
}
else
$objTp->setAttended3("NULL");

$objTp->UpdateRecord();

$col=$objTp->colUpdated;

$objUtility->saveSqlLog("TT", $objTp->returnSql);
$objUtility->saveSqlLog("TT", $col);
if ($col>0)
$upd++;
}//for loop
$_SESSION['msg']="Updated ".$upd." Record";
header( 'Location: TrgAtn.php?tag=1&mtype=100');
}//code=2


function Calculate($d1,$d2,$d3)
{
$i=0;
if(strlen($d1)>1)
$i++;
if(strlen($d2)>1)
$i++;
if(strlen($d3)>1)
$i++;
return($i);
}

?>
</form>
</body>
</html>
