<?php
include("Menuhead.html");
?>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{

$("#Name").change(function(event){
$("#msg").hide();
});


var dp=document.getElementById('Pollcategory').value;
if(dp==6)
{    
$("#DivCell").show();
$("#DivLac").hide();
$("#DivCell1").show();
$("#DivLac1").hide();
}
else
{
$("#DivCell").hide();   
$("#DivLac").show();
$("#DivCell1").hide();
$("#DivLac1").show();
}

$("#Pollcategory").change(function(event){
var dp=document.getElementById('Pollcategory').value;
if(dp==6)
{    
$("#DivCell").show();
$("#DivLac").hide();
$("#DivCell1").show();
$("#DivLac1").hide();
}
else
{
$("#DivCell").hide();   
$("#DivLac").show();
$("#DivCell1").hide();
$("#DivLac1").show();
}   
});


});//End document ready
</script>


<script type="text/javascript" src="validation.js"></script>
<script language="javascript">
<!--
function CalcAge(dt)
{
var data="Dor="+document.getElementById('Dor').value;
data=data+"&Age="+document.getElementById('Age').value;
MyAjaxFunction("POST","CalculateAge.php",data,'Age',"TEXT"); //This will calculate Age
}


function direct()
{
myform.Slno.value=myform.pid.value;    
var i=myform.Slno.value;    
if (isNumber(i))
{
myform.action="Form_poling.php?tag=2&ptype=0&mtype=0";
myform.submit();
}
}

function reload()
{
myform.action="Form_poling.php?tag=2&ptype=1&mtype=3";
myform.submit();
}


function direct1()
{
var i;
i=0;
}

function swift()
{
window.location="SelectDepartment.php?tag=1";
}

function check()
{
document.getElementById('back4').disabled=true;    
window.open("checklist.php","_blank");
}


function swift2office()
{
window.location="form_Department.php?tag=1";
}


function writetostatus(input)
{
alert('ok');
window.status=input
return true
}


function enu()
{
if (myform.pid.selectedIndex>0)    
myform.edit1.disabled=false;
else
myform.edit1.disabled=true;    
}


function redirect(i)
{
    
if(i==100)    
{
myform.action="Form_poling.php?tag=3";
myform.submit();    
}
if (i==17) //only pollcategory
{
//myform.action="Form_poling.php?tag=2&ptype=1&mtype="+i;
//myform.submit();
var j=myform.Pollcategory.value;
if (j==6) //cell duty
myform.Cellname.disabled=false;
else
{
 myform.Cellname.disabled=true;
 myform.Cellname.selectedIndex=0;
} //j==9
} //i=17
}


function validate()
{
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="mainmenu.php?tag=1";
var a=myform.Slno.value ;
var b=myform.R_Lac.selectedIndex ;
var c=myform.Name.value ;
var c_length=parseInt(c.length);
var d=myform.Desig.selectedIndex;
var h=myform.Sex.value ;
var h_index=myform.Sex.selectedIndex;
var i=myform.Age.value ;
var j=myform.Homeconst.value ;
var j_index=myform.Homeconst.selectedIndex;
var k=myform.Placeofresidence.value ;
var k_length=parseInt(k.length);
var l=myform.Basic.value ;
//var m=myform.Scale.value ;
//var m_length=parseInt(m.length);
var n=myform.Gradepay.value ;
var q=myform.Pollcategory.value ;
var q_index=myform.Pollcategory.selectedIndex;
var r=myform.Cellname.value ;
var r_index=myform.Cellname.selectedIndex;
var v=myform.Gazeted.value ;
var v_length=parseInt(v.length);
var w=myform.Phone.value ;
var w_length=parseInt(w.length);
var ab=myform.Dor.value ;
var ae=myform.Remarks.value ;
var ae_length=parseInt(ae.length);

var ok;
ok=(q==6 && r_index>0) || (q!=6 && r_index==0)
//alert(ok);
var mob
if(w_length>0)
mob=checkMobile('Phone',0);
else
mob=true;
if (mob==false)
alert('Invalid Mobile Number');

var Ps=document.getElementById('Psno').value;
var vsl=document.getElementById('Vsl').value;
var Epic=document.getElementById('Epic').value;

if (validateString(Epic) && validateString(Ps) && validateString(vsl) &&  isNumber(i)&& b>0 && isNumber(l) && isNumber(a)==true && mob==true && isNumber(i)  && notNull(c) && validateString(c) && checkName(c) && c_length<=100 && d>0 && notNull(h) && h_index>0  && j_index>0  && validateString(k) && k_length<=200 &&  q_index>0  && ok==true  && notNull(v) && validateString(v) && v_length<=1  && validateString(w) && w_length<=11 &&  isdate(ab,0)  && SimpleValidate(ae) && ae_length<=250)
{
if(parseInt(i)<18 || parseInt(l)<1000)
alert('Check Age(>=18) or Basic Pay(>=1000)');
else
{
document.getElementById('Save1').disabled=true;
myform.action="Insert_poling.php";
myform.submit();
}
}
else
{
//alert('ok1')
if (SelectBoxIndex('Desig')==0)
{
alert('Select Designation ');
myform.Designation.focus();
}
else if (SelectBoxIndex('Sex')==0)
{
alert('Select Sex');
myform.Sex.focus();
}
else if (SelectBoxIndex('Pollcategory')==0)
{
alert('Select Pollcategory');
myform.Pollcategory.focus();
}
else if (StringValid('Placeofresidence',0)==false)
{
alert('Check Address');
myform.Address.focus();
}
else if (SelectBoxIndex('Homeconst')==0)
{
alert('Select Home LAC');
myform.Homeconst.focus();
}
else if (SelectBoxIndex('R_Lac')==0)
{
alert('Select Residential LAC');
myform.R_Lac.focus();
}
else if (NumericValid('Basic',0)==false)
{
alert('Non Numeric Value in Basic');
myform.Basic.focus();
}
else if (NumericValid('Gradepay',0)==false)
{
alert('Non Numeric Value in Gradepay');
myform.Gradepay.focus();
}
else if (SelectBoxIndex('Cellname')==0 && q==6 ) //Category Ceel Name
{
alert('Select Cellname');
myform.Cellname.focus();
}
else if (StringValid('Remarks',0)==false)
{
alert('Check Remarks');
myform.Remarks.focus();
}
else if (DateValid('Dor',0)==false)
{
alert('Check Date of Retire');
myform.Dor.focus();
}
else if (isNumber(i)==false)
{
alert('Check Age');
myform.Age.focus();
}
else    
alert('Check All Mandatory Data(Marked as *)');
}
//
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

function setMe()
{
//myform.Name.focus();
myform.Cellname.disabled=true;
}
</script>
<body onload="setMe()">
<?php
header('Refresh: 240;url=IndexPage.php?tag=1');
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.sex.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.cell.php';
require_once './class/class.designation.php';
require_once './class/class.department.php';
require_once './class/class.status.php';

$objUtility=new Utility();
$objPoling=new Poling();

$Groupno=0;
$objS=new Status();
$objS->setSerial("1");
$disentry="";

$sel="";

$Psno="";
$Vsl="";
$Epic="";
if ($objS->EditRecord())
{
if ($objS->getEntry_stop()=="Y") 
{
$disentry=" disabled";   
$cap="X";
echo $objUtility->alert("Data entry is Temporarily Stoped, Contact Administrator");
}
}

//Start Verify
$allowedroll=3; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

$deparray=array();
//Initialise Deparray
$deparray['Depcode']=0;
$deparray['Depname']="";
$deparray['Deptype']="A";
$deparray['Depconst']="0";
$deparray['Beeo']=0;


if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;
   
if ($_tag>3)
$_tag=0;

$pid=0;


if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

$mvalue=array();
$pkarray=array();


//echo "mtype".$mtype;

if ($_tag==1 || $_tag==3)//Return from Action Form or reset
{
$_SESSION['update']==0;    
if (isset($_SESSION['deparray']))    
$deparray=$_SESSION['deparray'];
else
{
$deparray['Depcode']=0;
$deparray['Depname']="-";
$deparray['Deptype']="S";
$deparray['Depconst']="0";
$deparray['Beeo']="0";      
}
if (isset($_SESSION['mvalue']))
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
else
{
$mvalue[0]=$objPoling->MaxSlno();
$mvalue[1]="0";//Rslno
$mvalue[2]="";//Name
$mvalue[3]="";//Desig
$mvalue[4]="";//Sex
$mvalue[5]="0";//Age
$mvalue[6]="";//Homeconst
$mvalue[7]="";//Placeofresidence
$mvalue[8]="0";//Basic
$mvalue[9]="-1";//Scale
$mvalue[10]="0";//Gradepay
$mvalue[11]="-1";//Pollcategory
$mvalue[12]="0";
$mvalue[13]="N";//Gazeted
$mvalue[14]="";//Phone
$mvalue[15]="";//Dor
$mvalue[16]="";//Remarks
}//end isset mvalue

if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
}

if ($_tag==0) //Initial Page Loading
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

$tempd=trim($objDepartment->getDepartment());
if(strlen($objDepartment->getAddress())>2)
$tempd=$tempd.",".$objDepartment->getAddress();
$deparray['Depname']=$tempd;
$deparray['Deptype']=$objDepartment->getDep_type();
$deparray['Depconst']=$objDepartment->getDep_const();
$deparray['Beeo']=$objDepartment->getBeeo_code();
$_SESSION['dtype']=$deparray['Deptype'];
$_SESSION['deparray']= $deparray; 
}//if editrecord

$ptype=0;
$pid=0;
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objPoling->MaxSlno() Function Here if required and Load in $mvalue[0]
$mvalue[0]=$objPoling->MaxSlno();//Slno
// Call $objPoling->MaxRslno() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Rslno
$mvalue[2]="";//Name
$mvalue[3]="";//Desig
$mvalue[4]="";//Sex
// Call $objPoling->MaxAge() Function Here if required and Load in $mvalue[5]
$mvalue[5]="0";//Age
// Call $objPoling->MaxHomeconst() Function Here if required and Load in $mvalue[6]
$mvalue[6]="-1";//Homeconst
$mvalue[7]="";//Placeofresidence
// Call $objPoling->MaxBasic() Function Here if required and Load in $mvalue[8]
$mvalue[8]="0";//Basic
$mvalue[9]="-1";//Scale
// Call $objPoling->MaxGradepay() Function Here if required and Load in $mvalue[10]
$mvalue[10]="0";//Gradepay
// Call $objPoling->MaxPollcategory() Function Here if required and Load in $mvalue[11]
$mvalue[11]="-1";//Pollcategory
$mvalue[12]="0";
$mvalue[13]="N";//Gazeted
$mvalue[14]="";//Phone
$mvalue[15]="";//Dor
$mvalue[16]="";//Remarks
$_SESSION['mvalue']=$mvalue;
}



if ($_tag==2)//Post Back 
{
if (isset($_SESSION['deparray']))    
$deparray=$_SESSION['deparray'];
else
{
$deparray['Depcode']=0;
$deparray['Depname']="-";
$deparray['Deptype']="S";
$deparray['Depconst']="0";
$deparray['Beeo']="0";      
}

$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;
if (isset($_POST['pid']))
$pid=$_POST['pid'];
else
$pid=0;
if (isset($_POST['Slno']))
$objPoling->setSlno($_POST['Slno']);
else
$objPoling->setSlno("0");
//Post Back on Select Box Change,Hence reserve the value
if ($ptype==1)
{
// CAll MaxNumber Function Here if require and Load in $mvalue
$mvalue[0]=$_POST['Slno'];
$mvalue[1]=$_POST['Rslno'];
$mvalue[2]=$_POST['Name'];
$mvalue[3]=$_POST['Desig'];
$mvalue[4]=$_POST['Sex'];
$mvalue[5]=$_POST['Age'];
$mvalue[6]=$_POST['Homeconst'];
if (!is_numeric($mvalue[6]))
$mvalue[6]=-1;
$mvalue[7]=$_POST['Placeofresidence'];
$mvalue[8]=$_POST['Basic'];
$mvalue[9]=$_POST['R_Lac'];
$mvalue[10]=$_POST['Gradepay'];
$mvalue[11]=$_POST['Pollcategory'];
if (!is_numeric($mvalue[11]))
$mvalue[11]=-1;
if(isset($_POST['Cellname']))
$mvalue[12]=$_POST['Cellname'];
else
$mvalue[12]=0;    
if (!is_numeric($mvalue[12]))
$mvalue[12]=-1;
$mvalue[13]=$_POST['Gazeted'];
$mvalue[14]=$_POST['Phone'];
$mvalue[15]=$_POST['Dor'];
$mvalue[16]=$_POST['Remarks'];
} //ptype=1

if ($objPoling->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objPoling->getSlno();
$mvalue[1]=$objPoling->getR_Lac();
$mvalue[2]=$objPoling->getName();
$mvalue[3]=$objPoling->getDesig();
$mvalue[4]=$objPoling->getSex();
$mvalue[5]=$objPoling->getAge();
$mvalue[6]=$objPoling->getHomeconst();
$mvalue[7]=$objPoling->getPlaceofresidence();
$mvalue[8]=$objPoling->getBasic();
$mvalue[9]=$objPoling->getR_lac();
$mvalue[10]=$objPoling->getGradepay();
$mvalue[11]=$objPoling->getPollcategory();
$mvalue[12]=$objPoling->getCellname();
$mvalue[13]=$objPoling->getGazeted();
$mvalue[14]=$objPoling->getPhone();
$mvalue[15]=$objUtility->to_date($objPoling->getDor());
$mvalue[16]=$objPoling->getRemarks();
$Groupno=$objPoling->getGrpno();

$psvsl=$objPoling->getPsno_Vsl();
$tr=explode("/",$psvsl);
if(isset($tr[0]))
$Psno=$tr[0];
if(isset($tr[1]))
$Vsl=$tr[1];
if(isset($tr[2]))
$Epic=$tr[2];

if  (($Groupno>0 || $objS->getAlloweditaftergrouping()=="N") && $roll>1) 
{
$disentry=" disabled";   
$cap="X";
echo $objUtility->alert("Cannot Update Since,Person is Already Grouped or Edit Option is Locked,Contact Administrator");
}
//14oct
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]="";
$mvalue[1]="";
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]=-1;
$mvalue[5]="";
$mvalue[6]=-1;
$mvalue[7]="";
$mvalue[8]="";
$mvalue[9]="-1";
$mvalue[10]="";
$mvalue[11]=-1;
$mvalue[12]="0";
$mvalue[13]="N";
$mvalue[14]="";
$mvalue[15]="";
$mvalue[16]="";
}
}
} //tag==2
//Start of Form Design

if(isset($deparray['Depconst']))
{
$objL=new Lac();
$objL->setCode($deparray['Depconst']);
if($objL->EditRecord())
$Dlac=$objL->getName ();
else
$Dlac=""; 
}
else
{
$Dlac=""; 
}


?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=98%>
<form name=myform action=insert_poling.php  method=POST >
<tr><td colspan=4 align=Center bgcolor=#CCFF99><font face=arial size=3><b><?php echo $deparray['Depname']?>  </b><br></font>
<div id=msg>
<font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font>
</div>
</td></tr>
<?php $i=0; ?>
<tr>
<td align=right width="15%" bgcolor=#FFFF33><font color=black size=2 face=arial>Poling ID</font></td><td align=left width="80%" colspan="3" bgcolor=#FFFF33>
<input type=hidden size=4 name="Slno" id="Slno" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Slno',1)"  onblur="ChangeColor('Slno',2)" readonly>

<input type=hidden size=4 name="Depcode" id="Depcode" value="" onfocus="ChangeColor('Slno',1)"  onblur="ChangeColor('Slno',2)" readonly>

<font face="arial" size="3" color="black"><b>
<?php
 echo $mvalue[0];
 $i++; //Now i=1?>
</b>&nbsp;&nbsp;<font face="arial" size="2" color="#FF33CC">
<?php 
$row=$objPoling->getList($deparray['Depcode']);
echo "Total Record-".count($row) ;
?>
<input type=hidden size=8 name="Rslno" id="Rslno" value="0">
<select name=pid style="font-family: Arial;background-color:#9966CC;color:white; font-size: 14px;width:255px" onchange="enu()">
<option selected value="0">Click Here to Edit Existing Employee
 <?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($pid==$row[$ind]['Slno'])
echo "<option  selected value=".chr(34).$row[$ind]['Slno'].chr(34).">".$row[$ind]['Name'];
else
echo "<option  value=".chr(34).$row[$ind]['Slno'].chr(34).">".$row[$ind]['Name'];
}
?>
</select>
&nbsp;
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:80px" onfocus="ChangeFocus('Name')" disabled>
<?php 
if ($Groupno>0)
echo "Group No-".$Groupno;
?>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Name of Officer</font></td><td align=left bgcolor=white>
<input type=text size=30 name="Name" id="Name" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 14px" maxlength=100 onfocus="ChangeColor('Name',1)"  onblur="ChangeColor('Name',2)">
<font color=red size=3 face=arial>*</font>
</td>
<?php $i++; //Now i=3?>
<td align=right bgcolor=white><font color=black size=2 face=arial>Desig</font></td><td align=left bgcolor=white>
<?php 
$objDesig=new Designation();
$objDesig->setCondString("Dep_type='".$deparray['Deptype']."' order by Designation"); //Change the condition for where clause accordingly
$row=$objDesig->getRow();
?>
<select name=Desig id="Desig" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:150px" >
<?php $dval="-";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Designation'])
echo "<option selected value=".chr(34).$row[$ind]['Designation'].chr(34).">".$row[$ind]['Designation'];
else
echo "<option  value=".chr(34).$row[$ind]['Designation'].chr(34).">".$row[$ind]['Designation'];
}
?>
</select>
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Sex</font></td><td align=left bgcolor=white>
<?php 
$objSex=new Sex();
$objSex->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objSex->getRow();
?>
<select name=Sex id="Sex" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:100px" onchange=redirect(8)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
{
if ($Groupno==0)
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
}
?>
</select><font color=red size=4 face=arial>*</font>
</td>
<?php $i++; //Now i=5?>
<td align=right bgcolor=white><font color=black size=2 face=arial>Age</font></td><td align=left bgcolor=white>
<input type=text size=8 maxlength="2" name="Age" id="Age" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Age',1)"  onblur="ChangeColor('Age',2)">
<font color=red size=4 face=arial>*</font></td>
</tr>
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Home LAC</font></td><td align=left bgcolor=white>
<?php 
$objLac=new Lac();
$objLac->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Homeconst id="Homeconst" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:150px" onchange=redirect(10)>
<?php $dval="-1";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Code'])
echo "<option selected value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
else
{
if ($Groupno==0)
echo "<option  value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
}
}
?>
</select>
<font color=red size=4 face=arial>*</font>
</td>
<?php $i++; //Now i=7?>
<td align=right bgcolor=white><font color=black size=2 face=arial>Address</font></td><td align=left bgcolor=white>
<input type=text size=35 name="Placeofresidence" id="Placeofresidence" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=200 onfocus="ChangeColor('Placeofresidence',1)"  onblur="ChangeColor('Placeofresidence',2)">
</td>
</tr>
<?php $i++; //Now i=8?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>PS No, Voter Serial & Epic No</font></td><td align=left bgcolor=white>
<input type=text size=3 name="Psno" id="Psno" value="<?php echo $Psno; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=4 onfocus="ChangeColor('Psno',1)"  onblur="ChangeColor('Psno',2)">
&nbsp;&nbsp;
<input type=text size=3 name="Vsl" id="Vsl" value="<?php echo $Vsl; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=4 onfocus="ChangeColor('Vsl',1)"  onblur="ChangeColor('Vsl',2)">
&nbsp;&nbsp;
<input type=text size=10 name="Epic" id="Epic" value="<?php echo $Epic; ?>" maxlength="10" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=4 onfocus="ChangeColor('Epic',1)"  onblur="ChangeColor('Epic',2)">
</td>
<?php $i++; //Now i=9?>
<td align=right bgcolor=white><font color=black size=2 face=arial>Residential LAC</font></td><td align=left bgcolor=white>
<input type=hidden size=35 name="Scale" id="Scale" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Scale',1)"  onblur="ChangeColor('Scale',2)">
<?php 
$objLac=new Lac();
$objLac->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=R_Lac id="R_Lac" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:150px" )>
<?php $dval="-1";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Code'])
echo "<option selected value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
else
{
if ($Groupno==0)
echo "<option  value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
}
}
?>
</select>
<font color=red size=4 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=10?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Basic & Grade Pay</font></td><td align=left bgcolor=white>
<input type=text size=8 maxlength="5" name="Basic" id="Basic" value="<?php echo $mvalue[8]; ?>" onfocus="ChangeColor('Basic',1)"  onblur="ChangeColor('Basic',2)">
<font color=red size=4 face=arial>*</font>+
<input type=text size=8 maxlength="5" name="Gradepay" id="Gradepay" value="<?php echo $mvalue[10]; ?>" onfocus="ChangeColor('Gradepay',1)"  onblur="ChangeColor('Gradepay',2)">
</td>
<?php $i++; //Now i=11?>
<td align=right bgcolor=white><font color=black size=2 face=arial>Poll Category</font></td><td align=left bgcolor=white>
<?php 
if($roll>1)
$pcond="Code>0"; 
else
$pcond="1=1";
$objCategory=new Category();
$objCategory->setCondString($pcond); //Change the condition for where clause accordingly
$row=$objCategory->getRow();
?>
<select name=Pollcategory id="Pollcategory" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:150px" onchange=redirect(17)>
<?php $dval="-1";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Code'])
echo "<option selected value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
else
{
if ($Groupno==0)
echo "<option  value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
}
}
?>
</select><font color=red size=4 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=12?>
<?php $i++; //Now i=13
if ($mvalue[13]=="Y")
$sel="selected";
else
$sel="";
?>

<tr>
<td align="right"  id="DivLac"><font color=black size=2 face=arial>Working LAC</td>
<td align="left"  id="DivLac1"><input type="text" size="25" value="<?php echo $Dlac;?>" disabled></td>

<td align=right bgcolor=white id="DivCell"><font color=black size=2 face=arial>Name of Cell</font></td>
<td align=left bgcolor=white id="DivCell1">
<?php 
$objCell=new Cell();
$objCell->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objCell->getRow();
?>
<select name=Cellname id="Cellname" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:150px" onchange=redirect(18)>
<?php $dval="0";?>
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
</td>

<td align=right bgcolor=white><font color=black size=2 face=arial>Rank of Officer</font></td><td align=left bgcolor=white>
<select name="Gazeted" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:150px">
<option value="N">Non Gazetted Officer/Staff     
<option value="Y" <?php echo $sel?>>Gazetted Officer 
</select><font color=red size=4 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=14?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Mobile No</font></td><td align=left bgcolor=white>
<input type=text size=15  maxlength="11" name="Phone" id="Phone" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=11 onfocus="ChangeColor('Phone',1)"  onblur="ChangeColor('Phone',2)">
<font color=blue size=2 face=arial>
eg. 99098-10231</font>
</td>
<?php $i++; //Now i=15?>
<td align=right bgcolor=white><font color=black size=2 face=arial>Retire Date</font></td><td align=left bgcolor=white>
<input type=text size=10 maxlength="10" name="Dor" id="Dor" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Dor',1)"  onblur="ChangeColor('Dor',2)"  onchange=CalcAge(<?php echo $mvalue[$i]; ?>)>
<font size=1 face=arial color=blue>DD/MM/YYYY</font>
</td>
</tr>
<?php $i++; //Now i=16?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Remarks</font></td><td align=left bgcolor=white colspan="3">
<textarea name="Remarks" id="Remarks" rows="2" cols="100" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=255 onfocus="ChangeColor('Remarks',1)"  onblur="ChangeColor('Remarks',2)">
<?php echo $mvalue[$i]; ?>
</textarea>
</td>
<?php $i++; //Now i=17?>
<tr>
<?php
if ($_SESSION['update']==1)
$cap="Update Record";
//echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
$cap="Save Record";
//echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
<td align=center colspan="4" height=35 bgcolor=#CCFF99>
<input type=button value="<?php echo $cap?>"  name=Save id="Save1" onclick=validate()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:black;width:130px" <?php echo $disentry;?>>
&nbsp;&nbsp;
<input type=button value="Back to Office Selection"  name=back2 onclick=swift() onfocus="ChangeFocus('Name')" style="font-family:arial; font-size: 14px ; background-color:yellow;color:black;width:180px">
&nbsp;&nbsp;
&nbsp;&nbsp;
<input type=button value="Back to Office Entry"  name=back3 onclick=swift2office() style="font-family:arial; font-size: 14px ; background-color:orange;color:black;width:150px">
&nbsp;&nbsp;
&nbsp;&nbsp;
<input type=button value="My Check List"  name=back4 id="back4" onclick=check() style="font-family:arial; font-size: 14px ; background-color:yellow;color:black;width:130px">
</td></tr>
</table>
</form>
<p align=center>
<font color=black size=3 face=arial>Field marked <font color=red size=4 face=arial>*
 <font color=black size=3 face=arial>are Mandatory</font>
</p>
<?php

if($mtype==0)//Default
echo $objUtility->focus("Name");

if($mtype==3)//Postback from Name
echo $objUtility->focus("Desig");



if($mtype==17)//Postback from Pollcategory
{
echo $objUtility->focus("Cellname");
}


?>
<?php
if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);

include("footer.htm");
?>
</body>
</html>
