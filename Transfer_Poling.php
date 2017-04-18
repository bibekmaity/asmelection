<html>
<head>
<title>Transfer</title>
</head>
<script type="text/javascript" src="validation.js"></script>

<script language=javascript>
<!--
function home()
{
window.location="SelectDepartment.php?tag=1";
}

function loadcat(newbox,box1,box2,box3)
{
var a=parseInt(myform.tot.value);

if(document.getElementById(box1).checked==true)
{
document.getElementById(box2).checked=false;
document.getElementById(box3).checked=false;
document.getElementById(newbox).value=document.getElementById(box1).value;
myform.tot.value=a+1;
}
else
{    
document.getElementById(newbox).value=0;
myform.tot.value=a-1;
}
   
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
   
//var c=myform.Res.value; 
//if(1==1)
//{
//var name = confirm("Confirm?");
//if (name == true)    
//{
myform.Save.disabled=true;
myform.action="Transfer_Poling.php?tag=2";
myform.submit();
//}    
//}
//else
//alert('Enter Reason for Exemption')    
}


function direct()
{
i=myform.finddep.value;    
window.location="Transfer_Poling.php?mydep="+i   
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
if ($roll==-1 || $roll>3 )
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


if (isset($_GET['dcode']))
{    
$dcode=$_GET['dcode'];
$_SESSION['dcode']=$dcode;
}
else
$dcode=0;

if (isset($_GET['mydep'])) //postback from Department text Box
{    
$dcode=$_SESSION['dcode'];
$finddep=$_GET['mydep'];
}
else
$finddep="";    

$depname="";
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


$a1=$objPoling->rowCount("countcategory=1");
$a2=$objPoling->rowCount("countcategory=2");
$a3=$objPoling->rowCount("countcategory=3");

if(isset($_GET['res']))    
echo $objUtility->alert ("Updated Data");    
  
$sql="  depcode=".$dcode." and deleted='N' and countgrpno=0 and pollcategory not in(3,4,5) order by name";
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=95%>
<tr>
<td align=center bgcolor=#6699CC colspan="6"><font size=3 face=arial color=black>
<B>ASSIGN  COUNTING DUTY TO POLING PERSON<br>
<?php echo $depname;?>
</B></td></tr>
    <tr>
<td align=center bgcolor=#6699CC width="6%"><font size=2 face=arial color=blue>
    <b>Slno
</td>  
<td align=center bgcolor=#6699CC width="30%"><font size=2 face=arial color=blue>
<b>Name and Designation
</td>
<td align=center bgcolor=#6699CC width="16%"><font size=2 face=arial color=blue>
<b>Election Duty As
</td>
<td align=center bgcolor=#6699CC width="16%"><font size=2 face=arial color=blue>
<b>Supervisor<br><font color="#FFFF00">Total-
<?php echo $a1;?>
</td>
<td align=center bgcolor=#6699CC width="16%"><font size=2 face=arial color=blue>
<b>Assistant<br><font color="#FFFF00">Total-
<?php echo $a2;?>
</td>
<td align=center bgcolor=#6699CC width="16%"><font size=2 face=arial color=blue>
<b>Static Observer<br><font color="#FFFF00">Total-
<?php echo $a3;?>
</td>
</tr>
<?php
$rowcount=0;
$tval=0;


$objPoling->setCondString($sql);
$row=$objPoling->getAllRecord();
$objCat=new Category();
for($ii=0;$ii<count($row);$ii++)
{
$objCat->setCode($row[$ii]['Pollcategory']);
if($objCat->EditRecord())
$duty=$objCat->getName();
else
$duty="";
$checked1="";
$checked2="";
$checked3="";
$newcategory=$row[$ii]['Countcategory'];
if($newcategory>0)
$tval++;
if($newcategory==1)
$checked1=" checked=checked";
if($newcategory==2)
$checked2=" checked=checked";
if($newcategory==3)
$checked3=" checked=checked";

if($row[$ii]['Selected']="Y" && $row[$ii]['Grpno']>0)
$duty=$duty."(Duty Done)";

$rowcount++;
$sl=$row[$ii]['Slno'];
?>
<tr>
<?php  
$Slno="Slno".$rowcount; 
$Newcat="Newcat".$rowcount;
?>
<td align=center><font face="arial" size="2">
<input type=hidden name="<?php echo $Slno;?>" size=5    value="<?php echo $row[$ii]['Slno'];?>" style="font-family: Arial;background-color:white;color:black;font-size: 18px" readonly>
<input type=hidden name="<?php echo $Newcat;?>" id="<?php echo $Newcat;?>" size=2  value="<?php echo $newcategory;?>">
<?php echo $rowcount;?>
</td>
<td align=left><font face="arial" size="2">
<?php echo $row[$ii]['Name'].", ".$row[$ii]['Desig'];?>
</td>
<td align=center><font face="arial" size="2">
<?php echo $duty;?>
</td>
<?php  
$Cat1="Cat1".$rowcount;
$Cat2="Cat2".$rowcount;
$Cat3="Cat3".$rowcount;
?>
<td align=center><font face="arial" size="2">
<input type=checkbox name="<?php echo $Cat1;?>" id="<?php echo $Cat1;?>" value="1" onclick="loadcat('<?php echo $Newcat;?>','<?php echo $Cat1;?>','<?php echo $Cat2;?>','<?php echo $Cat3;?>')"  <?php echo $checked1;?>>
</td>
<td align=center><font face="arial" size="2">
<input type=checkbox name="<?php echo $Cat2;?>" id="<?php echo $Cat2;?>" value="2" onclick="loadcat('<?php echo $Newcat;?>','<?php echo $Cat2;?>','<?php echo $Cat1;?>','<?php echo $Cat3;?>')" <?php echo $checked2;?>>
</td>
<td align=center><font face="arial" size="2">
<input type=checkbox name="<?php echo $Cat3;?>" id="<?php echo $Cat3;?>" value="3" onclick="loadcat('<?php echo $Newcat;?>','<?php echo $Cat3;?>','<?php echo $Cat1;?>','<?php echo $Cat2;?>')" <?php echo $checked3;?>>
</td>
</tr>
<?php
} //for loop
$_SESSION['rowcount']=$rowcount;
?>
<tr><td align=right bgcolor=#FFFFCC>
 <input type=hidden value="<?php echo $tval;?>" name=tot id="tot">
  
</td><td align=left bgcolor=#FFFFCC colspan=5>
<?php $mystyle="font-family:arial; font-size: 12px ;font-weight:bold; background-color:orange;color:black;width:100px";
 ?>
<input type=button value=TRANSFER  name=Save onclick="validate()" style="<?php echo $mystyle;?>" >
<?php $mystyle="font-family:arial; font-size: 12px ;font-weight:bold; background-color:#99FFCC;color:black;width:200px";
 ?>
<input type=button value="BACK TO SELECTION" name=back1 id=back2 style="<?php echo $mystyle;?>" onclick=home()>
&nbsp;&nbsp;

</td></tr>
</table>
<?php
}//$code==1



if ($code==2) //PostBack Submit
{
$objPoling=new Poling();
if(isset($_SESSION['rowcount']))
$tot=$_SESSION['rowcount'];
else
$tot=0;
$success=0;     
for($i=1;$i<=$tot;$i++)
{
$Slno="Slno".$i; 
$Newcat="Newcat".$i;   
if(isset($_POST[$Slno]))
$Slno=$_POST[$Slno];
else 
$Slno=0;    

if(isset($_POST[$Newcat]))
$Newcat=$_POST[$Newcat];
else 
$Newcat=0; 
if($Slno>0)
{
$sql="update poling set Countgrpno=0,Countselected='N', Countcategory=".$Newcat." where Slno=".$Slno;   
if($objPoling->ExecuteQuery($sql))
{
$success++;
}
} //$Slno>0
} //for LOOP
header('Location:Transfer_Poling.php?tag=0&res=1');
}//code=2


?>
</form>
</body>
</html>
