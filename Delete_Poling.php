<html>
<head>
<title>Mark for Deletion</title>
</head>
<script type="text/javascript" src="validation.js"></script>

<script language=javascript>
<!--
function home()
{
window.location="SelectDepartment.php?tag=1";
}

function dis()
{
var i=myform.Department.selectedIndex;
if (i>0)
myform.Save1.disabled=false;
else
myform.Save1.disabled=true;    
}

function enu()
{
    
//alert('ok');
if (myform.del.checked==true)
{
myform.Res.value="-"; 
myform.Res.disabled=true; 
}
else
{
myform.Res.disabled=false; 
}    
}

function place(i)
{
myform.Mslno.value=i;
if(parseInt(i)>0)
myform.Save1.disabled=false;    
}

function validate()
{
   
var c=myform.Res.value; 
if(notNull(c) && validateString(c))
{
var name = confirm("Exempt Poling person?");
if (name == true)    
{
myform.action="Delete_Poling.php?tag=2";
myform.submit();
}    
}
else
alert('Enter Reason for Exemption')    
}


function direct()
{
i=myform.finddep.value;    
window.location="Delete_Poling.php?mydep="+i   
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
require_once './class/class.deptype.php';

$objPH=new Poling_history();

$objUtility=new Utility();
$objDepartment=new Department();


$roll=$objUtility->VerifyRoll();
if ($roll==-1 || $roll>0 )
header( 'Location: SelectDepartment.php');

$dt=date('Y-m-d');
$user=$_SESSION['uid'];

$objPoling=new Poling();
if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;

if (isset($_SESSION['username']))
$username=$_SESSION['username'];
else
$username="";    


//if (isset($_GET['dcode']))
//{    
//$dcode=$_GET['dcode'];
//$_SESSION['dcode']=$dcode;
//}
//else
//$dcode=0;




if (isset($_GET['mydep'])) //postback from Department text Box
{    
$dcode=$_SESSION['dcode'];
$finddep=$_GET['mydep'];
}
else
$finddep="";    


if (isset($_SESSION['deparray']))
{
$deparray=$_SESSION['deparray'];
$dtype=$deparray['Deptype'];
$depname=$deparray['Depname'];
}
else
$dtype="a";
?>
<form name=myform action=""  method=POST >
 
<?php
if ($code==0) //Loading from SelectDepartment
{
$dcode=0;

if(isset($_POST['Depcode']))
{
$dcode=$_POST['Depcode'];
//echo "POst ".$dcode;
}
else
{
if(isset($_GET['dcode']))
$dcode=$_GET['dcode'];
//echo "GET ".$dcode;
}

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

  
$sql="  depcode=".$dcode." order by name";
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=80%>
<tr>
<td align=center bgcolor=#CCFFCC colspan="3"><font size=2 face=arial color=red>
Mark Poling Person from <b><?php echo $depname?></b>
 for Deletion</td></tr>
    <tr>
<td align=center bgcolor=#CCFFCC width="10%"><font size=3 face=arial color=blue>
Slno
</td>
<td align=center bgcolor=#CCFFCC width="60%"><font size=3 face=arial color=blue>
Name and Designation
</td>
<td align=center bgcolor=#CCFFCC width="30%"><font size=3 face=arial color=blue>
Remarks
</td>
</tr>
<?php
$rowcount=0;
$objPoling->setCondString($sql);
$row=$objPoling->getAllRecord();
//echo $objPoling->returnSql;

for($ii=0;$ii<count($row);$ii++)
{
$dis=""; 
$col="black";   
$rowcount++;
$sl=$row[$ii]['Slno'];
if ($row[$ii]['Deleted']=="Y" || $objPoling->isSelected4Trainee($sl,1) || $objPoling->isSelected4Trainee($sl,3) || $objPoling->isSelectedinGroup($sl) )
$dis=" disabled";

$msg=$row[$ii]['Remarks'];
if ($row[$ii]['Deleted']=="Y")
{
$msg="Already Exempted";
$col="grey";
}
if($objPoling->isSelected4Trainee($sl,1) || $objPoling->isSelected4Trainee($sl,3))
{
$msg="Selected in Training";
$dis=" disabled";
}
if($objPoling->isSelectedinGroup($sl))
{
$msg="Selected in Group";  
$dis=" disabled";
}
?>
<tr>
<?php  $Slno="Slno".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=hidden name="<?php echo $Slno;?>" size=5    value="<?php echo $row[$ii]['Slno'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px" readonly>
<?php echo $rowcount;?>
</td>
<td align=left><font face="arial" size="2" color=<?php echo $col;?>>
<?php  $Tag="Tag".$rowcount; ?>
<input type=radio Name="Idno" value="<?php echo $row[$ii]['Slno'];?>" onclick="place(<?php echo $row[$ii]['Slno'];?>)" <?php echo $dis;?>>
<?php echo $row[$ii]['Name'].", ".$row[$ii]['Desig'];?>
</td>
<td align=left><font face="arial" size="2">
<?php echo $msg;?>
</td>

</tr>
<?php
} //for loop
$_SESSION['rowcount']=$rowcount;
?>
<tr><td align=left bgcolor=#CCFFCC colspan=3>
Enter Reason for Exemption</td>
</tr>
<tr>
<td align="left" colspan=3>  
    
<textarea name="Res" id="Res"  rows=2 cols=80 style="font-family: Arial;background-color:white;color:black;font-size: 12px;font-weight:bold;">
</textarea>
<input type="hidden" size="1" name="Mslno" >
</td></tr>

<tr><td align=right bgcolor=#CCFFCC>
<?php if (1==2 && $roll==0 && $objUtility->CriticalAllowed()==true)
{ ?>
<font face="arial" size="2" color="red">
Permanently Delete
<input type="checkbox" name="del" style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:20px" onclick="enu()">
<?php }?>
       
</td><td align=left bgcolor=#CCFFCC>
<input type=hidden name=Depcode id=Depcode value=<?php echo $dcode;?> >
<input type=button value=Exempt  name=Save1 onclick="validate()" style="font-family:arial; font-size: 14px;font-weight:bold ; background-color:red;color:black;width:100px" disabled>
</td><td align=center bgcolor=#CCFFCC>
<input type=button value=Back name=back1 id=back2 style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" onclick=home()>
&nbsp;&nbsp;

</td></tr>
</table>
<?php
}//$code==1



if ($code==2) //PostBack Submit
{
 
$objPoling=new Poling();
$rc=0;

if (isset($_POST['del'])) 
$delete=true;
else 
$delete=false;    

if(isset($_POST['Depcode']))
$dcode=$_POST['Depcode'];
else
$dcode=0;

//echo "post dcode=".$dcode."<br>";

$name="";  
if (isset($_POST['Mslno']))   
{    
$Slno=$_POST['Mslno'];
 

$objPoling->setSlno($Slno);
$objPoling->setDeleted("Y");
$objPoling->setRemarks("Exempted on ".date('d/m/y')." by ".$username);
if ($delete==true)  
{   
$objPoling->ExecuteQuery("delete from poling_history where pid=".$Slno) ;   
$res=$objPoling->DeleteRecord();
}
else
{
$res=$objPoling->UpdateRecord();
$objPoling->EditRecord();
$name=$objPoling->getName();
}
}//isset
//header('Location:Delete_Poling.php?tag=0');
//echo $name."<br>";
if(strlen($name)>1)
echo $objUtility->AlertNRedirect("Exempted ".$name,"Delete_poling.php?tag=0&dcode=".$dcode);
else
echo $objUtility->AlertNRedirect("","Delete_poling.php?tag=0&dcode=".$dcode);
}//code=2

?>

</form>
</body>
</html>
