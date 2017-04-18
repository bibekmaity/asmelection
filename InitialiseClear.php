
<?php
include("Menuhead.html");
?>
<script language=javascript>
<!--
function home()
{
window.location="mainmenu.php?tag=1";
}

function ref()
{
window.location="InitialiseClear.php?tag=0";
}

function process()
{
myform.mybutton.disabled=true; 
//myform.h.disabled=true;
myform.action="InitialiseClear.php?tag=2";
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
require_once './class/class.poling.php';
require_once './class/utility.class.php';
require_once './class/class.status.php';
require_once './class/class.psname.php';
//require_once './class/class.polinggroup.php';
require_once './class/class.final.php';
require_once './class/class.lac.php';
require_once './class/class.bu.php';
require_once './class/class.cu.php';
require_once './class/class.groupstatus.php';
require_once './class/class.training.php';
require_once './class/class.Poling_training.php';

$objPT=new Poling_training();
$objT=new Training();

$objP=new Poling();


$objUtility=new Utility();
$objGs=new groupstatus();
//Start Verify
$allowedroll=1; //Change according to Business Logic
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
$Evmcount=0;
$Groupcount=0;
$Microcount=0;
$Rancount=0;
$pgstatus=0;
$mgstatus=0;
$cgstatus=0;
for ($i=0;$i<count($row);$i++)
{
$mstatus=$objLac->groupStatus($row[$i]['Code']);
if($mstatus>$pgstatus)
$pgstatus=$mstatus;   
    
if($objLac->MicrogroupStatus($row[$i]['Code'])>$mgstatus)
$mgstatus= $objLac->MicrogroupStatus($row[$i]['Code']);

$objFinal->setLac($row[$i]['Code']);
$objFinal->setMtype("1"); //1 means second level poling group formation
if ($objFinal->EditRecord())
$Groupcount++;   

$objFinal->setMtype("2"); //3 means evm(CU+BU) paired to LAC
if ($objFinal->EditRecord())
$Rancount++; 


$objFinal->setMtype("3"); //3 means evm(CU+BU) paired to LAC
if ($objFinal->EditRecord())
$Evmcount++; 


$objFinal->setMtype("5"); //5 means all micro selection for A=locked to LAC
if ($objFinal->EditRecord())
$Microcount++; 
}


$dt=date('Y-m-d');
$user=$_SESSION['uid'];


if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;
?>
<?php

$cgstatus=$objLac->CommonCountgroupStatus();

$msgFirst="";
$msgEvm="";
$msgTrg1="";
$msgTrg2="";
$msgPoll="";
$msgMicro="";
$msgPostg="";
$msgRan="";
$msgMRan="";
$msgCRan="";
$msgCount="";
$disF="";
$dis1="";
$disM="";
$disPoll="";
$disPoll="";
$disMicro="";
$disCgrp="";
$disPost="";
$disEvm="";
$disRan3=" disabled";
$disRanM3=" disabled";
$disRanC=" disabled";

if ($objT->rowCount("Phaseno=1")==0 && $objPT->rowCount("Phaseno=1")==0) //Training batch doesnot exist
{
$dis1=" disabled";
$msgTrg1="Nothing to Clear";
}

if ($objT->rowCount("Phaseno=3")==0 && $objPT->rowCount("Phaseno=3")==0) //Micro Training batch doesnot exist
{
$disM=" disabled";
$msgTrg2="Nothing to Clear";
}


echo "<p align=center>";

$pcount=0;
if ($code==2) //PostBack Submit
{
if (isset($_POST['First'])) //Clear First Level
{
mysql_query ("delete  from testgroup");
mysql_query ("update Category set Firstrandom='N',Selected=0,Allow_dep_lac=0,Allow_res_lac=0,Allow_home_lac=0");
mysql_query ("update Poling set Selected='N',Grpno=0 where Selected='Y'");
mysql_query ("update status set randomised=0");
mysql_query ("update Poling set rnumber=0 where Selected='N' and Pollcategory=1 order by rnumber limit 300");
echo "Cleared First Level Randomisation<br>";
$pcount++;
}

if (isset($_POST['trg'])) //Clear Training Selection
{
mysql_query ("delete  from poling_training where phaseno=1");
mysql_query ("delete  from training where phaseno=1");
echo "Cleared First Phase Training data<br>";
$pcount++;
}

if (isset($_POST['trgM'])) //Clear Micro Training Selection
{
mysql_query ("delete  from poling_training where phaseno=3");
mysql_query ("delete  from training where phaseno=3");
echo "Cleared Micro Observer Training data<br>";
$pcount++;
}

if (isset($_POST['trgPost'])) //Clear Post group Training Selection
{
mysql_query ("delete  from poling_training where phaseno=2");
mysql_query ("delete  from training where phaseno=2");
mysql_query ("update polinggroup set TRGGROUP=0");
echo "Cleared Post group Training data<br>";
$pcount++;
}


if (isset($_POST['grp']))
{
mysql_query ("delete  from polinggroup");
mysql_query ("delete  from final where mtype=1");
mysql_query ("update  Poling set grpno=0,selected='Y' where (selected='Y' or selected='R') and pollcategory in(1,2,3,4,5)");
//mysql_query ("update  status set Randomised=0");
echo "Cleared Poling Group Selection<br>";
$pcount++;
}

if (isset($_POST['mgrp']))
{
mysql_query ("delete  from Microgroup");
mysql_query ("delete  from final where mtype in(5,6)");
mysql_query ("update  Poling set grpno=0 where (selected='Y' or selected='R') and pollcategory=7");
//mysql_query ("update  status set Randomised=0");
echo "Cleared Micro Group Selection<br>";
$pcount++;
}

if (isset($_POST['Ran3'])) //3rd Level Randomisation
{
mysql_query ("delete  from final where mtype=2");
mysql_query ("update  Polinggroup set Reserve='N' where reserve='Y'");
mysql_query ("update  poling set Selected='Y' where pollcategory in (1,2,3,4,5) and Selected='R'");
echo "Cleared Third Level Randomisation<br>";
$pcount++;
}

if (isset($_POST['RanM3'])) //3rd Level Randomisation
{
mysql_query ("delete  from final where mtype=6");
mysql_query ("update  Microgroup set Micropsno=0");
mysql_query ("update  poling set Selected='Y' where pollcategory=7 and Selected='R'");
echo "Cleared Poling Station Allocation for Micro Observer<br>";
$pcount++;
}


if (isset($_POST['evm'])) //Clear and Randomise EVM
{
mysql_query ("delete  from evmgroup");
mysql_query ("delete  from final where mtype in(3,4)");
mysql_query ("update BU set used='N' where (used='Y' or used='R')");
mysql_query ("update CU set used='N' where (used='Y' or used='R')");
echo "Cleared  EVM Allocation<br>";
$pcount++;
}

if(isset($_POST['cgrp']))  //Counting group
{
$sql="update poling set Countselected='N',Countgrpno=0 where Countcategory in(1,2,3)";
mysql_query ($sql);
$sql="Delete from countinggroup";
mysql_query($sql);
$sql=" delete from final where mtype=7 ";
mysql_query($sql);   
echo "Cleared  All Counting Group<br>";
$pcount++;
}
//Process data
if (isset($_POST['RanC3'])) //3rd Level Randomisation
{
mysql_query ("delete  from final where mtype=8");
echo "Cleared Hall/Table Allocation for Counting person<br>";
$pcount++;
}
echo "</p>";   
if($pcount>0)
echo $objUtility->AlertNRedirect("Done", "InitialiseClear.php?tag=0");
else
echo $objUtility->AlertNRedirect("", "InitialiseClear.php?tag=0");
    

}//code=2



if ($code==0) //Initial Loading SelectDepartment
{
$objStatus->setSerial("1");
$objStatus->EditRecord();

if($objStatus->getFirst_level()=="Y")
{
$disF=" disabled";
$msgFirst=" Locked by System Manager";
}
else //even if not locked, check if group formation is in process
{
//first check if training group started    
if($objLac->TrainingGroupExist(1)==true)
{
$disF=" disabled";
$msgFirst="Training Batch Started";  
} 
//then check if group formation started
if($pgstatus>1) 
{
$disF=" disabled";
$objGs->setCode($pgstatus);
if($objGs->EditRecord())
$msgFirst="Not Allowed since ".$objGs->getDetail()." for some LAC";  
}   
 
} //$objStatus->getFirst_level()   


if($objStatus->getTraining_group()=="Y")
{
$dis1=" disabled";
$msgTrg1=" Locked by System Manager";
}
else //even if not locked, check if group formation is in process
{
if($pgstatus>1) 
{
$dis1=" disabled";
$objGs->setCode($pgstatus);
if($objGs->EditRecord())
$msgTrg1="Not Allowed since ".$objGs->getDetail()." for some LAC";  
}    
} 



if($objStatus->getMicro_trg()=="Y")
{
$disM=" disabled";
$msgTrg2=" Locked by System Manager";
}
else
{ 
    
if($mgstatus>1)    
{
$disM=" disabled";
$objGs->setCode($mgstatus);
if($objGs->EditRecord())
$msgTrg2="Not Allowed since ".$objGs->getDetail()." for some LAC";  
}
}

//MICROGROUP
if($objStatus->getMicro_group()=="Y")
{
$disMicro=" disabled";
$msgMicro=" Locked by System Manager";
}
else
{
//echo $mgstatus;  
if($mgstatus>4 || $mgstatus==1)
{    
$disMicro=" disabled";
$objGs->setCode($mgstatus);
if($objGs->EditRecord())
$msgMicro=$objGs->getDetail()." for some LAC";  
}
else
$disMicro="";    
}//getMicro_group()=="Y




if($objStatus->getPoll_group()=="Y")
{
$disPoll=" disabled";
$disPost=" disabled";
$msgPoll=" Locked by System Manager";
}
else
{
if($pgstatus >4 || $pgstatus==0)
{    
$disPoll=" disabled";
$disPost=" disabled"; 
$objGs->setCode($pgstatus);
if($objGs->EditRecord())
$msgPoll=$objGs->getDetail()." for some LAC";  
} 
else
{
$disPoll=" ";
$disPost="";    
}    
}//getPoll_group()=="Y


if($objStatus->getEvm_group()=="Y")
{
$disEvm=" disabled";
$msgEvm=" Locked by System Manager";
}
else
{
if($Evmcount>0)
$disEvm=" "; 
else
{    
$disEvm=" disabled";
$msgEvm=" Group not yet formed";
}
}

if($cgstatus>1)
{
$disCgrp="";
$msgCount="Grouped Some LAC";
}
else
$disCgrp=" disabled";


if($pgstatus>4 && $roll==0)
$disRan3="";

if($pgstatus>4 && $roll>0)
$msgRan=" Allowed only for System Manager(Root User)";    

if($mgstatus>4 && $roll==0)
$disRanM3="";

if($mgstatus>4 && $roll>0)
$msgRan=" Allowed only for System Manager(Root User)";   

if($cgstatus>4 && $roll==0)
$disRanC="";

if($cgstatus>4 && $roll>0)
$msgCRan=" Allowed only for System Manager(Root User)"; 


if($Rancount>0)
$msgRan="Randomised ".$Rancount." LAC";

if($roll>0)
{
$disPoll=" disabled";
$disPost=" disabled";
$msgPoll=" Allowed only for System Manager(Root User)"; 
}

//echo "ran".$Rancount;
}//$code==0 
//echo $dis4;  

if($objP->rowCount("Selected='Y'")==0)
{
$msgFirst="Nothing to Clear";
$disF=" disabled ";
}

  
?>
 <form name="myform" method="post" action="Initialise.php?tag=2">
<table align=center border=0 width=100%>
<tr><td colspan="2" align="center" bgcolor="#99CC99"><B>CLEAR SELECTION</td></tr>   
<TR><td align=right width="50%"><font face="Arial" size="2">Clear First Level Randomisation </font>
  <font face="Arial" size="2">&nbsp; </font>
<input type=checkbox name=First value="sel" <?php echo $disF?>></td>
</td>
<td align=left "50%"><font face="Arial" size="1">
<?php echo $msgFirst;?></td>
</tr> 
<TR><td align=right><font face="Arial" size="2">Clear Poling Personnel Training Selection </font>
  <font face="Arial" size="2">&nbsp; </font>
<input type=checkbox name=trg value="sel" <?php echo $dis1?>></td>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgTrg1;?></td>
</tr>    
<TR><td align=right><font face="Arial" size="2">Clear Micro Observer Training Selection </font>
  <font face="Arial" size="2">&nbsp; </font>
<input type=checkbox name=trgM value="sel" <?php echo $disM?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgTrg2;?></td>
</tr>  
 <TR><td align=right><font face="Arial" size="2">
Clear Micro Observer Selection
<input type=checkbox name=mgrp   value="sel" <?php echo $disMicro?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgMicro;?></td>
</tr> 
<TR><td align=right><font face="Arial" size="2">
Clear Poling Group Selection
<input type=checkbox name=grp   value="sel" <?php echo $disPoll?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgPoll;?></td>
</tr>
<TR><td align=right><font face="Arial" size="2">Clear&nbsp; Post Group Training 
  Selection&nbsp;&nbsp; </font>
<input type=checkbox name=trgPost <?php echo $disPost?> value="sel"></td>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgPostg;?></td>
</tr>
 <tr><td align=right><font face="Arial" size="2">
Clear EVM Randomisation
<input type=checkbox name=evm value="sel" <?php echo $disEvm?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgEvm;?>
</td>
</tr> 
<tr><td align=right><font face="Arial" size="2">
Clear Third Level Randomisation(PS Allocation)
<input type=checkbox name=Ran3 value="sel" <?php echo $disRan3?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgRan;?>
</td> 
</tr>
<tr><td align=right><font face="Arial" size="2">
Clear PS Allocation for Micro Observer
<input type=checkbox name=RanM3 value="sel" <?php echo $disRanM3?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgMRan;?>
</td></td> 
</tr>
<TR><td align=right><font face="Arial" size="2">
Clear Counting Group Selection
<input type=checkbox name=cgrp   value="sel" <?php echo $disCgrp?>>
</td>
<td align=left><font face="Arial" size="1">
<?php echo $msgCount;?>
</td>
</tr>
<tr><td align=right><font face="Arial" size="2">
Clear Hall Allocation for Counting group
<input type=checkbox name=RanC3 value="sel" <?php echo $disRanC;?>>
</td>
<td>
    <font face="Arial" size="1">
<?php echo $msgCRan;?>
    
</td>
</tr>
<tr>
    <td></td>
<td align=left>
<input type=button value="Proceed to Clear"  name=mybutton onclick=process()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:#669999;color:black;width:160px" >
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
