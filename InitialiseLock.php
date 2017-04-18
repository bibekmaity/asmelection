
<?php
include("Menuhead.html");
?>
<script language=javascript>
<!--
function home()
{
window.location="mainmenu.php?tag=1";
}
function process()
{
myform.mybutton.disabled=true; 
//myform.h.disabled=true;
myform.action="InitialiseLock.php?tag=2";
myform.submit();
}

</script>
<BODY>
<script language=javascript>
<!--
</script>
<body onload=setMe()>
<?php
session_start();
//require_once './class/class.poling.php';
require_once './class/utility.class.php';
require_once './class/class.status.php';
require_once './class/class.psname.php';
require_once './class/class.poling.php';
require_once './class/class.final.php';
require_once './class/class.lac.php';
require_once './class/class.bu.php';
require_once './class/class.cu.php';

$objUtility=new Utility();

$objP=new Poling();
//Start Verify
$allowedroll=0; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: mainmenu.php?unauth=1');
//End Verify

$objStatus=new Status();

$objLac=new Lac();
$objFinal=new LacFinal();

$objLac->setCondString("code>0 and code in(select distinct lac from psname)");
$row=$objLac->getAllRecord();
$totlac=count($row);
$evmcount=0;
$groupcount=0;
$microcount=0;

for ($i=0;$i<count($row);$i++)
{
$objFinal->setLac($row[$i]['Code']);
$objFinal->setMtype("1"); //1 means second level poling group formation
if ($objFinal->EditRecord())
$groupcount++;   

$objFinal->setMtype("3"); //3 means evm(CU+BU) paired to LAC
if ($objFinal->EditRecord())
$evmcount++;  

$objFinal->setMtype("5"); //5 means all micro selection for A=locked to LAC
if ($objFinal->EditRecord())
$microcount++; 
}





$dt=date('Y-m-d');
$user=$_SESSION['uid'];


if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;
?>
<?php
echo "<p align=center>";
if ($code==2) //PostBack Submit
{

if (isset($_POST['stopentry']))
{
mysql_query ("update status set entry_stop='Y'");
echo  "Locked Data Entry<br>";
}
else
{
mysql_query ("update status set entry_stop='N'");
echo  "Unlocked Data Entry<br>";
}

if (isset($_POST['AllowEdit']))
mysql_query ("update status set alloweditaftergrouping='Y'");
else
mysql_query ("update status set alloweditaftergrouping='N'");


if (isset($_POST['lockevm']))
{
mysql_query ("update status set evm_group='Y'");
echo  "Locked EVM Group <br>";
}

if (isset($_POST['locktrain']))
{
mysql_query ("update status set training_group='Y'");
echo  "Locked Training Group selection<br>";
}

if (isset($_POST['lockmicrotrain']))
{
mysql_query ("update status set Micro_trg='Y'");
echo  "Locked Micro Observer Training Selection <br>";
}

if (isset($_POST['lockpollgroup']))
{
mysql_query ("update status set poll_group='Y'");
echo  "Locked Polling Group <br>";
}

if(isset($_POST['lockfirst']))
{
mysql_query ("update status set First_level='Y'");
echo  "Locked First Level randomisation <br>";
}

if (isset($_POST['lockmicrogroup']))
{
mysql_query ("update status set micro_group='Y'");
echo  "Locked Micro Observer Selection <br>";
}

//Process data

echo "</p>";   
}//code=2

$msgFirst="";
$msgEvm="";
$msgTrg1="";
$msgTrg2="";
$msgPoll="";
$msgMicro="";



if ($code==0 || $code==2) //Initial Loading SelectDepartment
{
$row=$objStatus->getAllrecord();

if ($row[0]['Alloweditaftergrouping']=="Y")
$mcheck=" checked=checked";
else
$mcheck="";

if ($row[0]['First_level']=="Y")    
{
$dislock=" disabled";
$clock=" checked=checked";
$msgFirst="<image src=lock.ico width=25 height=15>Unlock by Updation First_level='N' in STATUS Table";
}
else
{   
if($objP->FirstLevelCompleted() && $objP->Randomised(7)==true)    
{
$dislock="";
$clock="";
}
else 
{
$dislock=" disabled";
$clock=" ";  
$msgFirst="First Level Not Completed for Micro Observer and Poling Person";
}
}//$row[0]['First_level']=="Y

if ($row[0]['Training_group']=="Y")    
{
$dis1=" disabled";
$c1=" checked=checked";
$msgTrg1="<image src=lock.ico width=25 height=15>Unlock by Updation Training_group='N' in STATUS Table";
}
else
{    
$dis1="";
$c1="";
}

if ($row[0]['Micro_trg']=="Y")    
{
$dismicrotrg=" disabled";
$cmicrotrg=" checked=checked";
$msgTrg2="<image src=lock.ico width=25 height=15>Unlock by Updation Micro_trg='N' in STATUS Table";
}
else
{    
$dismicrotrg="";
$cmicrotrg="";
}



$c2="";
if ($row[0]['Poll_group']=="Y")  //Poling Group Locked
{
$dis2=" disabled";
$c2=" checked=checked";
$msgPoll="<image src=lock.ico width=25 height=15>Unlock by Updation Poll_group='N' in STATUS Table";
}
else
{ 
if ($groupcount==$totlac) //Poling group made final for all LAC
$dis2="";
else
{
$dis2=" disabled";
$msgPoll="Poling Groups for All LAC are not Temporary Locked";
}
}


$c3="";
if ($row[0]['Evm_group']=="Y" )
{
$dis3=" disabled";
$c3="checked=checked";
$msgEvm="<image src=lock.ico width=25 height=15>Unlock by Updation Evm_group='N' in STATUS Table";
}
else
{    
if ($evmcount==$totlac)
$dis3="";
else
{
$dis3=" disabled";  
$msgEvm="EVM Groups for All LAC are not Temporary Locked";
}
}


$cmicro="";
if ($row[0]['Micro_group']=="Y")  //Poling Group Locked
{
$dismicro=" disabled";
$cmicro=" checked=checked";
$msgMicro="<image src=lock.ico width=25 height=15>Unlock by Updation Micro_group='N' in STATUS Table";
}
else
{ 
if ($microcount==$totlac) //Poling group made final for all LAC
$dismicro="";
else
{
$dismicro=" disabled";
$msgMicro="Micro Observer for All LAC are not Temporary Locked";
}
}


if ($row[0]['Entry_stop']=="Y" )
$dis4=" checked=checked";
else
$dis4="";
}//$code==0 
//echo $dis4;    
?>
 <form name="myform" method="post" action="Initialise.php?tag=2">
<table align=center border=0 width=90% cellpadding="3">
<tr><td colspan="2" align="center" bgcolor="#99CC99">LOCK UNLOCK MANAGEMENT</td></tr>   
<tr>
<td align=right>
<font face="Arial" size="2"><font color="#FF0000">L</font>ock First Level Randomisation 
</font>
<input type=checkbox name=lockfirst value="sel" <?php echo $clock?>  <?php echo $dislock?>>
</td>
<td align="left"><font face="Arial" size="1"><?php echo $msgFirst;?></td></tr>
</tr>
<tr>
  <td align=right>
<font face="Arial" size="2"><font color="#FF0000">L</font>ock Training Batch Creation for Poling Person</font>
<input type=checkbox name=locktrain value="sel" <?php echo $c1?>  <?php echo $dis1?>>
</td>
<td align="left"> <font face="Arial" size="1"><?php echo $msgTrg1;?></td></tr>
</tr>
<tr>
  <td align=right>
<font face="Arial" size="2"><font color="#FF0000">L</font>ock Training Batch Creation for Micro Observer</font>
<input type=checkbox name=lockmicrotrain value="sel" <?php echo $cmicrotrg?>  <?php echo $dismicrotrg?>>
</td>
<td align="left"> <font face="Arial" size="1"><?php echo $msgTrg2;?></td></tr>
</tr>    
<TR><td align=right>
<font face="Arial" size="2">Final Lock All EVM Group</font>
<input type=checkbox name=lockevm value="sel" <?php echo $c3?> <?php echo $dis3?> >
</td>
<td align="left"><font face="Arial" size="1"><?php echo $msgEvm;?></td></tr>

<TR><td align=right>
<font face="Arial" size="2">Final Lock All Polling Group</font>
<input type=checkbox name=lockpollgroup value="sel" <?php echo $c2?> <?php echo $dis2?>  >
</td>
<td align="left"><font face="Arial" size="1"><?php echo $msgPoll;?></td></tr>
</tr> 
<TR><td align=right>
<font face="Arial" size="2">Final Lock All Micro Observer Selection</font>
<input type=checkbox name=lockmicrogroup value="sel" <?php echo $cmicro?> <?php echo $dismicro?>  >
</td>
<td align="left"><font face="Arial" size="1"><?php echo $msgMicro;?></td></tr>
</tr> 
<tr>
<td align=right>
<font face="Arial" size="2">Allow Edit After First Randomisation</font>
<input type=checkbox name=AllowEdit value="sel" <?php echo $mcheck?>>
</td></tr>
<TR><td align=right><font face="Arial" size="2">Stop Data Entry</font>
<input type=checkbox name=stopentry value="sel" <?php echo $dis4?>>
  </td>
 <tr><td>&nbsp;</td> 
<td align=left>
<input type=button value="Proceed"  name=mybutton onclick=process()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:black;width:120px" >

</td>
</tr>
</table>
</form>
</table> 
<p align="center">
    <font face="arial"    size="2" color="blue">

</form>
<?php
include("footer.htm");
?>
</body>
</html>
