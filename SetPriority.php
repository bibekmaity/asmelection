
<script language=javascript>
<!--
function home()
{
window.location="SelectDepartment.php?tag=1";
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
require_once './class/class.department.php';
require_once './class/class.priority.php';
require_once './class/class.poling_history.php';
require_once './header.php';
$objPH=new Poling_history();

$objUtility=new Utility();

$roll=$objUtility->VerifyRoll();
if ($roll==-1 || $roll>1 )
header( 'Location: index.php?msg=Unauthorised User');

$dt=date('Y-m-d');
$user=$_SESSION['uid'];

$objPoling=new Poling();
if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;


if (isset($_GET['dcode']))
$dcode=$_GET['dcode'];
else
$dcode=0;



if ($code==0) //Loading from SelectDepartment
{
if(isset($_POST['Depcode']))
$dcode=$_POST['Depcode'];
else
$dcode=0;
$objDepartment=new Department();
$objDepartment->setDepcode($dcode);
if ($objDepartment->EditRecord())
{
$deparray['Depcode']=$dcode;
$deparray['Depname']=$objDepartment->getDepartment();
$deparray['Deptype']=$objDepartment->getDep_type();
$deparray['Depconst']=$objDepartment->getDep_const();
$deparray['Beeo']=$objDepartment->getBeeo_code();
$_SESSION['dtype']=$deparray['Deptype'];
$_SESSION['deparray']= $deparray; 
}//if editrecord
$depname=$deparray['Depname'];

$sql=" Deleted='N' and Grpno=0 and depcode=".$dcode." order by name";
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=80%>
<form name=myform action=SetPriority.php?tag=2  method=POST >
<tr>
<td align=center bgcolor=#CCFFCC colspan="3"><font size=3 face=arial color=#FF66CC>
Set Duty Priority for <b><?php echo $depname?></b>
</td></tr>
    <tr>
<td align=center bgcolor=#CCFFCC width="10%"><font size=3 face=arial color=blue>
Slno
</td>
<td align=center bgcolor=#CCFFCC width="70%"><font size=3 face=arial color=blue>
Name and Designation
</td>
<td align=center bgcolor=#CCFFCC width="20%"><font size=3 face=arial color=blue>
Priority
</td>
</tr>
<?php
$rowcount=0;
$objPoling->setCondString($sql);
$row=$objPoling->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$rowcount++;
?>
<tr>
<?php  $Slno="Slno".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=hidden name="<?php echo $Slno;?>" size=5    value="<?php echo $row[$ii]['Slno'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px" readonly>
<input type=hidden name=Old_<?php echo $Slno;?>  value="<?php echo $row[$ii]['Slno'];?>">
<?php echo $rowcount;?>
</td>
<?php  $Name="Name".$rowcount; ?>
<td align=left><font face="arial" size="2">
<input type=hidden name="<?php echo $Name;?>" size=30    value="<?php echo $row[$ii]['Name'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 12px">
<input type=hidden name=Old_<?php echo $Name;?>  value="<?php echo $row[$ii]['Name'];?>">
<?php  $Desig="Desig".$rowcount; ?>
<input type=hidden name="<?php echo $Desig;?>" size=30    value="<?php echo $row[$ii]['Desig'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 12px">
<input type=hidden name=Old_<?php echo $Desig;?>  value="<?php echo $row[$ii]['Desig'];?>">
<?php echo $row[$ii]['Name'].", ".$row[$ii]['Desig'];?>
</td>
<?php  $Tag="Tag".$rowcount; ?>
<td align=center>
<select name="<?php echo $Tag;?>" style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:100px">
<?php
$objPriority= new Priority();
$row1=$objPriority->getRow();
for($jj=0;$jj<count($row1);$jj++)
{
if ($row[$ii]['Tag']==$row1[$jj][0])
echo "<option  selected value=".chr(34).$row1[$jj][0].chr(34).">".$row1[$jj][1];
else
echo "<option  value=".chr(34).$row1[$jj][0].chr(34).">".$row1[$jj][1];
}
?>
</select>
<input type=hidden name=Old_<?php echo $Tag;?>   value="<?php echo $row[$ii]['Tag'];?>">
</td>
</tr>
<?php
} //while
$_SESSION['rowcount']=$rowcount;
?>
<tr><td align=right bgcolor=#FFFFCC>
</td><td align=left bgcolor=#FFFFCC colspan="2">
<input type=submit value=Update  name=Save1>
<input type=button value=Back name=back1 id=back2 onclick=home()>
</td></tr>
</table>
<?php
}//$code==1
if ($code==2) //PostBack Submit
{

//echo $_SESSION['rowcount'];
for ($ind=1;$ind<=$_SESSION['rowcount'];$ind++)
{
$sql="update poling set ";
$updcount=0;
$oldName="Old_Name".$ind;
$Name="Name".$ind;

$Name=$_POST[$Name];
$oldName=$_POST[$oldName];

if ($objUtility->validate($Name))
{
if ($oldName!=$Name)
{
$sql=$sql."Name='".$Name."',";
$updcount++;
}
}
$oldDesig="Old_Desig".$ind;
$Desig="Desig".$ind;

$Desig=$_POST[$Desig];
$oldDesig=$_POST[$oldDesig];

if ($objUtility->validate($Desig))
{
if ($oldDesig!=$Desig)
{
$sql=$sql."Desig='".$Desig."',";
$updcount++;
}
}
$oldTag="Old_Tag".$ind;
$Tag="Tag".$ind;

$Tag=$_POST[$Tag];
$oldTag=$_POST[$oldTag];

if ($objUtility->validate($Tag))
{
if ($oldTag!=$Tag)
{
$sql=$sql."Tag='".$Tag."',";
$updcount++;
}
}
$oldSlno="Old_Slno".$ind;
$Slno=$_POST[$oldSlno];
$sql=$sql."Slno='".$Slno."'";
$sql=$sql." where ";
$oldSlno="Old_Slno".$ind;
$oldSlno=$_POST[$oldSlno];
$sql=$sql."Slno='".$oldSlno."'";
$msg="";
if ($updcount>0)
{
$res=$objPoling->ExecuteQuery($sql);
//echo $sql;
if ($res) //Save as SQL Log
{
$msg="Updated ".$updcount." Rows";
$objUtility->saveSqlLog("Poling",$sql);
//echo "&nbsp;<font color=blue size=2 face=arial>Success</font><br>";
$objPH->setPid($Slno);
$objPH->setRsl($objPH->maxRsl($Slno));
$objPH->setE_date($dt);
$objPH->setUser_name($user);
$objPH->setHistory("Tag-".$Tag);
$objPH->SaveRecord();
}
else
{
//echo "&nbsp;<font color=red size=2 face=arial>Fail<br></font>";
}
} //$updcount>0
}//for loop
$page="SelectDepartment.php?tag=1";

echo $objUtility->AlertNRedirect($msg,$page);
}//code=2
?>
</form>
</body>
</html>
