<html>
<head>
<title>Set Priority of Duty Assign</title>
</head>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="Validator.js"></script>

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

function direct()
{
i=myform.finddep.value;    
window.location="Shift_Poling.php?mydep="+i   
}

function LoadTextBox()
{
var i=document.getElementById('Editme').value;
document.getElementById('Depcode').value=i;
if(parseInt(i)>0)
document.getElementById('Save').disabled=false;
else
document.getElementById('Save').disabled=true;
}

function LoadDep()
{
var data="";
data=data+"Dname="+document.getElementById('dname').value;
var DivId="DivDep";//Set DIV ID Accordingly
MyAjaxFunction("POST","Load_Department.php?mtype=3&mval=0",data,DivId,"HTML");

}

function validate()
{
var i=parseInt(document.getElementById('Depcode').value);
var j=parseInt(document.getElementById('Counter').value);
if(i>0 && j>0)
{
myform.action="Shift_Poling.php?tag=2";
myform.submit();
}
else
alert('Invalid Selection');

}

function Add(a)
{
var i=parseInt(document.getElementById('Counter').value);
if(document.getElementById(a).checked==true)
i=i+1;
else
i=i-1;
document.getElementById('Counter').value=i;
}

</script>

<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
//On form Load Action  
var data="";
data=data+"Dname="+document.getElementById('dname').value;
var DivId="DivDep";//Set DIV ID Accordingly
MyAjaxFunction("POST","Load_Department.php?mtype=3&mval=0",data,DivId,"HTML");

}
);
//alert('loading');
</script>


<BODY>

<body onload=setMe()>
<?php
session_start();
require_once './class/class.poling.php';
require_once './class/utility.class.php';
require_once './class/class.department.php';
require_once './class/class.priority.php';
require_once './class/class.poling_history.php';
require_once './class/class.deptype.php';
require_once './header.php';
$objPH=new Poling_history();

$objUtility=new Utility();
$objDepartment=new Department();


$roll=$objUtility->VerifyRoll();
if ($roll==-1 || $roll>2 )
header( 'Location: indexPage.php?msg=Unauthorised User');

$dt=date('Y-m-d');
$user=$_SESSION['uid'];

$objPoling=new Poling();
if (isset($_GET['tag']))
$code=$_GET['tag'];
else
$code=0;

if ($code==0)
{   
if(isset($_POST['Depcode']))
$dcode=$_POST['Depcode'];
else
$dcode=0;

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
$_SESSION['dcode']=$dcode;
$depname=$deparray['Depname'];
$_SESSION['depname']=$depname;
} //$code=0

 
if($code==2)
{
//find New Department Detail
if (isset($_POST['Depcode']))
$newdcode=$_POST['Depcode'];   
else
$newdcode=0;

$objDepartment->setDepcode($newdcode);
if ($objDepartment->EditRecord())
{
$newdepname=$objDepartment->getDepartment();
$newdepconst=$objDepartment->getDep_const();
$newbeeo=$objDepartment->getBeeo_code();   
}
else
{
$newdepname="-";
$newdepconst="0";
$newbeeo="0";    
}


$objPoling=new Poling();
$rc=0;
for ($ind=1;$ind<=$_SESSION['rowcount'];$ind++)
{
$Tag="Tag".$ind;
    
if (isset($_POST[$Tag]))   
{    
$Slno="Slno".$ind;
$Slno=$_POST[$Slno];    
    
$objPoling->setSlno($Slno);
$objPoling->setDepcode($newdcode) ;
$objPoling->setBeeo_code($newbeeo);
$objPoling->setDepconst($newdepconst);
$objPoling->setDepartment($newdepname);
if ($objPoling->UpdateRecord())
{
$rc++;
$sql=$objPoling->returnSql;
$objUtility->saveSqlLog("Poling",$sql);
$objPH->setPid($Slno);
$objPH->setRsl($objPH->maxRsl($Slno));
$objPH->setE_date($dt);
$objPH->setUser_name($user);
$objPH->setHistory("Depart-".$newdepname);
$objPH->SaveRecord();
//echo $sql."<br>";
}    
} //isset

}//for loop
echo $objUtility->alert("Shifted ".$rc." Person to ".$newdepname);
}//code=2



?>
<form name=myform action="Shift_Poling.php?tag=2"  method=POST >
<?php
if ($code==0 ||$code==2) //Loading from SelectDepartment
{
if(isset($_SESSION['dcode']))
$dcode=$_SESSION['dcode'];
else
$dcode=0;
if(isset($_SESSION['depname']))
$depname= $_SESSION['depname'];
else
$depname="";

$sql=" depcode=".$dcode." order by name";
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<tr>
<td align=center bgcolor=#CCFFCC colspan="2"><font size=2 face=arial color=#FF66CC>
Transfer Poling Person from <b><?php echo $depname?></b> to another Office
</td></tr>
    <tr>
<td align=center bgcolor=#CCFFCC width="30%"><font size=3 face=arial color=blue>
Slno
</td>
<td align=center bgcolor=#CCFFCC width="70%"><font size=3 face=arial color=blue>
Name and Designation
</td>
</tr>
<?php
$rowcount=0;
$objPoling->setCondString($sql);
$row=$objPoling->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$rowcount++;
if ($row[$ii]['Deleted']=="Y")
$dis=" disabled";
else 
$dis="";
?>
<tr>
<?php  $Slno="Slno".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type=hidden name="<?php echo $Slno;?>" size=5    value="<?php echo $row[$ii]['Slno'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px" readonly>
<?php echo $rowcount;?>
</td>
<td align=left><font face="arial" size="2">
<?php  $Tag="Tag".$rowcount; ?>
<input type="checkbox" name="<?php echo $Tag;?>" id="<?php echo $Tag;?>" style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:50px" <?php echo $dis;?>  onclick="Add('<?php echo $Tag;?>')">
<?php echo $row[$ii]['Name'].", ".$row[$ii]['Desig'];?>
</td></tr>
<?php
} //while
$_SESSION['rowcount']=$rowcount;
?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Select New Office</font></td><td align=left bgcolor=#FFFFCC>
<div id="DivDep">
        
</div>
<input type=hidden name="Depcode" id="Depcode" size=1 value=0>
<input type=hidden name="Counter" id="Counter" size=1 value="0">

</td>
</tr>

<tr><td align=center bgcolor=#FFFFCC>
<input type=button value=Back name=back1 id=back2 onclick=home()>
</td><td align=left bgcolor=#FFFFCC>
<input type=button value="Transfer"  name=Save id=Save onclick=validate()  style="font-family:arial; font-size: 12px ; background-color:blue;color:black;width:80px" disabled>

&nbsp;&nbsp;
<font size="2" face="arial">
Type Few Character to Filter Office List
<input type=text name="dname" id="dname" size=20    value="" style="font-family: Arial;background-color:white;color:blue;font-size: 12px" onchange="LoadDep()">

</td></tr>
</table>
<?php
}//$code==1


?>
</form>
</body>
</html>
