<html>
<head>
<title>Select Department for Training Letter</title>
</head>
<script type="text/javascript" src="validation.js"></script>
<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function Add(box,i)
{
var a=parseInt(myform.Totsel.value);
if (document.getElementById(box).checked==true)    
a=a+i;
else
a=a-i;    
myform.Totsel.value=a;
myform.Totsel1.value=a;
if(a>0)
myform.del.disabled=false;
else
myform.del.disabled=true;    
}

function load()
{
myform.Depcode.value=myform.Department.value;
}

function direct1()
{
var i;
i=0;
}
function setMe()
{
myform.Dep_type.focus();
}

function loadopt(a)
{
document.getElementById('Signed').value=a;
}

function redirect(i)
{
myform.setAttribute("target","_self");
myform.action="SelectDep4App.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate(target)
{
myform.setAttribute("target", "_blank");
var a=myform.catg.value;
if(a==1)
{
myform.action="./PDFReport/AppLetter.php";
myform.submit();
}
if(a==3)
{    
myform.action="./PDFReport/AppLetterMicro.php";
myform.submit();
}
if(a==4)
{    
myform.action="./PDFReport/AppLetterCounting.php";
myform.submit();
}

}



function home()
{
window.location="mainmenu.php?tag=1";
}

//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}


</script>
<body>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.department.php';
require_once './class/class.deptype.php';
require_once './class/class.Poling.php';
require_once 'header.php';
$objUtility=new Utility();
$objDepartment=new Department();

//Start Verify
$allowedroll=3; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: mainmenu.php?unauth=1');
//End Verify


if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;


if (!is_numeric($_tag))
$_tag=0;
   
if ($_tag>2)
$_tag=0;

$deparray=array();

$catg=0;
if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$deparray=$_SESSION['deparray'];
$mvalue[0]=$deparray['Deptype'];//Dep_type
$mvalue[1]=$deparray['Depcode'];
$depname="";
//echo "mval-".$mvalue[0]."-".$mvalue[1];
//echo "dep-".$deparray['Deptype']."-".$deparray['Depcode'];
}


if ($_tag==0) //Initial Page Loading
{
if (isset($_GET['dcode']))
$dcode=$_GET['dcode'];
else
$dcode=0;    
$objDepartment->setDepcode($dcode);
if ($objDepartment->EditRecord())
{
$deparray['Depcode']=$dcode;
$deparray['Depname']=trim($objDepartment->getDepartment());
$deparray['Deptype']=$objDepartment->getDep_type();
$deparray['Depconst']=$objDepartment->getDep_const();
$deparray['Beeo']=$objDepartment->getBeeo_code();
}
else
{
$deparray['Depcode']=0;
$deparray['Depname']="";
$deparray['Deptype']="S";
$deparray['Depconst']="0";
$deparray['Beeo']="0";   
}
$_SESSION['deparray']= $deparray; //store department detail in session variable
    
$depname="";    
$_SESSION['update']=0;
$_SESSION['msg']="";
$mvalue[0]=$deparray['Deptype'];//Dep_type
// Call $objDepartment->MaxDepcode() Function Here if required and Load in $mvalue[1]
$mvalue[1]=$dcode;//Depcode
}


if ($_tag==2)//Post Back 
{

$mvalue[0]=$_POST['Dep_type']  ;  
if(isset($_POST['catg']))
$catg=$_POST['catg'];
else
$catg=0;


$_SESSION['mvalue']=$mvalue;

$ptype=$_GET['ptype'];
//Post Back on Select Box Change,Hence reserve the value

} //tag==2
$Sel1="";
$Sel2="";
$Sel3="";
if($catg==1)
$Sel1=" Selected";
if($catg==3)
$Sel2=" Selected";
if($catg==4)
$Sel3=" Selected";
?>
<table border=1 cellpadding=1 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=""  method=POST >
<tr><td colspan=2 align=Center bgcolor=#3399CC ><font face=arial size=3>Department/Office Selection Form for Final Appointment Letter<br>
</font></b>
    </td></tr>
<tr>
<td align=right bgcolor=white ><font color=black size=2 face=arial>Select Batch Category</font></td>
<td align=left bgcolor=white>
<select name="catg" onchange="redirect(1)" style="font-family: Arial;background-color:white;color:black;font-size: 14px;width:200px">
<option  value="0">-Select-
<option <?php echo $Sel1;?> value="1">Poling Officer
<option <?php echo $Sel2;?> value="3">Micro Observer   
<option <?php echo $Sel3;?> value="4">Counting Group      
</select>
<font face=arial size=1>
&nbsp;&nbsp;Signed by DEO
<input type=radio name="DEO" id="DEO"  onclick=loadopt("D") checked=checked>
RO
<input type=radio name="DEO" id="DEO"  onclick=loadopt("R") >
<input type=hidden size=1 name="Signed" id="Signed"  value="D" >
</td>
</tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white ><font color=black size=2 face=arial>Select Office Category</font></td><td align=left bgcolor=white>
<?php 
$objDeptype=new Deptype();
$cond="1=1";
if($catg==1)
$cond=" Code in (select dep_type from department where depcode in(Select depcode from poling where pollcategory in(1,2,3,4,5)))";

if($catg==3)
$cond=" Code in (select dep_type from department where depcode in(Select depcode from poling where pollcategory=7))";

if($catg==4)
$cond=" Code in (select dep_type from department where depcode in(Select depcode from poling where countcategory in(1,2,3)))";


$objDeptype->setCondString($cond); //Change the condition for where clause accordingly
$row=$objDeptype->getRow();
?>
<select name=Dep_type style="font-family: Arial;background-color:white;color:black;font-size: 14px;width:200px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>
 <font color=black size=2 face=arial>   
    &nbsp;Selected for Printing
<input type="textbox" name="Totsel" size="2" value="0" readonly>
    
</td>
</tr>
<?php $i++; //Now i=1?>
<tr><td colspan="2">
<table border="1" width="90%" cellpadding="2" cellspacing="0" align="center">
<tr><td width="10%" align="center" bgcolor="#66CCCC"><font color=black size=2 face=arial>SlNo</td><td width="50%" align="center" bgcolor="#66CCCC"><font color=black size=2 face=arial>Office/Institution</td><td width="15%" align="center" bgcolor="#66CCCC"><font color=black size=2 face=arial>Available</td><td width="15%" align="center" bgcolor="#66CCCC"><font color=black size=2 face=arial>Selected</td><td width="15%" align="center" bgcolor="#66CCCC"><font color=black size=2 face=arial>Click to Select</td></tr>
    <?php $dval="0";

$objBo=new Beeo();

$cond=" Dep_type='".$mvalue[0]."'" ;

if($catg==1)
$cond=$cond." and depcode in(Select depcode from poling where pollcategory in(1,2,3,4,5))";

if($catg==3)
$cond=$cond." and depcode in(Select depcode from poling where pollcategory=7)";


if($catg==4)
$cond=$cond." and depcode in(Select depcode from poling where pollcategory in(1,2,3))";


$objDepartment->setCondString($cond); //Change the condition for where clause accordingly
$row=$objDepartment->getRow();
$i=0;
$objP=new Poling();
for($ind=0;$ind<count($row);$ind++)
{

$objBo->setCode($row[$ind][3]);
if ($objBo->EditRecord() && $row[$ind][3]>0)
$addr="C/o BEEO ".$objBo->getName();
else
$addr=$row[$ind][2];



$phase=1;
$Dcode=$row[$ind][0];

if($catg==1)
{
$val=$objP->getTotPolingSelected($Dcode);
$tt=$objP->rowCount("Depcode=".$Dcode." and Pollcategory in(1,2,3,4,5)");
}
if($catg==3)
{
$val=$objP->getTotMicroSelected($Dcode);
$tt=$objP->rowCount("Depcode=".$Dcode." and Pollcategory=7");
}

if($catg==4)
{
$val=$objP->rowCount("Depcode=".$Dcode." and countgrpno>0 and countselected='Y' and  Pollcategory in(1,2,3)");
$tt=$objP->rowCount("Depcode=".$Dcode." and Pollcategory in(1,2,3)");
}


$Dep="Dep".($ind+1);
if($val==0)
$dis=" disabled";
else
$dis="";
if($val>0)
{
$i++;
?>
<tr>
<td align="center"><font color=black size=2 face=arial>    
<?php echo $i ;?>   
</td> 
<td align="left"><font color=black size=1 face=arial>    
<?php echo strtoupper($row[$ind][1]).",".strtoupper($addr) ;?>   
</td> 
<td align="center"><font color=black size=2 face=arial>    
<?php echo $tt ;?>   
</td>
<td align="center"><font color=black size=2 face=arial>    
<?php echo $val?>   
</td> 
<td align="center">
<input type="checkbox"  name="<?php echo $Dep;?>" id="<?php echo $Dep;?>" value="<?php echo $Dcode;?>" <?php echo $dis;?> onclick="Add('<?php echo $Dep;?>',<?php echo $val;?>)">
</td> 
</tr>
<?php
} //if $val>0
} //for Loop
?>
</table>
</td></tr>        

<tr><td align=right bgcolor=#3399CC>
<input type=hidden size=8 name="totdep" id="totdep" value="<?php echo $ind ;?>">
<input type=button value="Return to Menu"  name=back1 onclick=home() style="font-family:arial; font-size: 14px ; background-color:white;color:red;width:120px">

    </td>
<td align="left" bgcolor=#3399CC>
<font color=black size=2 face=arial>&nbsp;Selected for Printing
<input type="textbox" name="Totsel1" size="2" value="0" readonly>
<input type=button value="Print Report"  name=del onclick=validate()  style="font-family:arial;font-weight:bold font-size:14px;background-color:orange;color:blue;width:120px" disabled>

</td></tr>
</table>
</form>
</body>
</html>
