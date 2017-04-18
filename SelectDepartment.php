<?php
include("Menuhead.html");
?>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="Validator.js"></script>

<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function loadoption(i)
{
myform.Myoption.value=i;
myform.Save.disabled=false;
}

function LoadTextBox()
{
document.getElementById('Depcode').value=document.getElementById('Editme').value;

MyAjaxFunction("POST","Load_Department.php?mtype=1&mval="+document.getElementById('Depcode').value,"","HeadMsg","HTML");
MyAjaxFunction("POST","Load_Department.php?mtype=2&mval="+document.getElementById('Depcode').value,"","Avl","TEXT");

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

function redirect(i)
{
//myform.setAttribute("target", "_self");      
//myform.action="SelectDepartment.php?tag=2&ptype=1&mtype="+i;
//myform.submit();
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
var target=parseInt(myform.Myoption.value);
var a_index=myform.Dep_type.selectedIndex;

var b=document.getElementById('Depcode').value;
//var b_index=myform.Department.selectedIndex;
var avl=parseInt(document.getElementById('Avl').value);
if(target!=2 && avl==0)
alert('Insufficient Person');
if (a_index>0 && b>0 )
{
if (target==1 && avl>0)
{
myform.setAttribute("target", "_blank");  
myform.action="Report_Poling.php?tag=0&dcode="+b;
myform.submit();
}
if (target==2)
{
myform.setAttribute("target", "_self");    
myform.action="Form_Poling.php?tag=0&dcode="+b;
myform.submit();
}
if (target==3 && avl>0)
{
myform.setAttribute("target", "_self");     
myform.action="Shift_Poling.php?tag=0&dcode="+b;
myform.submit();
}

if (target==4 && avl>0)
{
myform.setAttribute("target", "_self");     
myform.action="setpriority.php?tag=0&dcode="+b;
myform.submit();
}

if (target==5 && avl>0)
{
myform.setAttribute("target", "_self");     
myform.action="delete_Poling.php?tag=0&dcode="+b;
myform.submit();
}

if (target==6 && avl>0)
{
myform.setAttribute("target", "_self");     
myform.action="Transfer_Poling.php?tag=0&dcode="+b;
myform.submit();
}
}
else 
alert('Invalid Selection');

}


function home()
{
window.location="mainmenu.php?tag=1";
}



//change the focus to Box(a)
function ChangeFocus(a)
{
//document.getElementById(a).focus();
}

function LoadDep()
{
var data="Deptype="+document.getElementById('Dep_type').value;
data=data+"&Dname="+document.getElementById('dname').value;
data=data+"&Depcode="+document.getElementById('Depcode').value;

var iBoxId="Depcode";///Set hidden input Box ID Accordingly
var DivId="DivDep";//Set DIV ID Accordingly
MyAjaxFunction("POST","Load_Department.php?mtype=0&mval="+document.getElementById(iBoxId).value  ,data,DivId,"HTML");

}  

</script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
//On form Load Action  
var data="Deptype="+document.getElementById('Dep_type').value;
data=data+"&Dname="+document.getElementById('dname').value;

var mval=document.getElementById('Depcode').value;
MyAjaxFunction("POST","Load_Department.php?mtype=0&mval="+mval,data,'DivDep',"HTML");

MyAjaxFunction("POST","Load_Department.php?mtype=1&mval="+mval,"","HeadMsg","HTML");
MyAjaxFunction("POST","Load_Department.php?mtype=2&mval="+mval,"","Avl","TEXT");

}
);
//alert('loading');
</script>
<body>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.department.php';
require_once './class/class.deptype.php';
require_once './class/class.poling.php';

$rspan=array();
$rspan[0]=6;
$rspan[1]=4;
$rspan[2]=4;
$rspan[3]=3;
$rspan[4]=1;

$objPol=new Poling();

$objUtility=new Utility();
$objDepartment=new Department();

$roll=$objUtility->VerifyRoll();
if ($roll==-1 || $roll>4 )
header( 'Location: index.php?msg=Unauthorised User');

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;


if (!is_numeric($_tag))
$_tag=0;
   
if ($_tag>2)
$_tag=0;

$deparray=array();

$avl=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if(isset($_SESSION['deparray']))
{
$deparray=$_SESSION['deparray'];
$mvalue[0]=$deparray['Deptype'];//Dep_type
$mvalue[1]=$deparray['Depcode'];
//echo $mvalue[1];
}
} //$tag==1


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
$tempd=trim($objDepartment->getDepartment());
if(strlen($objDepartment->getAddress())>2)
$tempd=$tempd.",".$objDepartment->getAddress();
$deparray['Depname']=$tempd;
$deparray['Deptype']=$objDepartment->getDep_type();
$_SESSION['dtype']=$deparray['Deptype'];
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

  
//Start of Form Design



//if($avl==0)
//$dis=" disabled";
//else
//$dis=" ";
$dis="";
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=95%>
<form name=myform action=form_Poling.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc height="30"><font face=arial size=3>Selection Form of Office/Institution/School/College <br>
</font><font face=arial color=red size=1><b>
<div id="HeadMsg">
        
</div>
    </font>
</td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Type</font></td><td align=left bgcolor=white>
<?php 
$objDeptype=new Deptype();
$objDeptype->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objDeptype->getRow();
?>
<select name=Dep_type id="Dep_type" style="font-family: Arial;background-color:white;color:black;font-size: 14px;width:200px" onchange="LoadDep()">
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
    <font face="arial" size="1" color="blue">
    Type Few Character to filter
<input type="text" name="dname" id="dname" size="25" value="" onchange="LoadDep()" onfocus="ChangeColor('dname',1)"  onblur="ChangeColor('dname',2)">

</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Office</font></td><td align=left bgcolor=white>
<div id="DivDep">
        
</div>
<input type=hidden size=8 name="Depcode" id="Depcode" value="<?php echo $mvalue[1];?>">
</td>
</tr>

<?php //List Poling Person

if ($roll<=4) //Guest User and Above
{
?>
<tr><td align=right valign=center rowspan="<?php echo $rspan[$roll];?>"><font size="2" face="arial">Select Option</td>
<td  align="left"><font size="2" face="arial">
<input type=radio value="1"  name=Opt onclick="loadoption(1)" <?php echo $dis;?>>
List Poling Person
</td></tr>
<?php } ?>       
<?php
if ($roll<=3) //DEO and Above
{
?>
<tr>
<td  align="left"><font size="2" face="arial">
<input type=radio value="2"  name=Opt onclick="loadoption(2)">
Poling Person Entry
</td></tr>
<?php } ?> 
<?php
if ($roll<=2) //Super User and Above
{
?>
<tr>
<td  align="left"><font size="2" face="arial">    
<input type=radio value="3"  name=Opt onclick="loadoption(3)" <?php echo $dis;?>>
Shift Poling Person(Change Office/Instiution/College)
</td></tr>
<?php } ?> 
<?php
if ($roll<1) //Only Root USer
{
?>
<tr>
<td  align="left"><font size="2" face="arial">    
<input type=radio value="4"  name=Opt onclick="loadoption(4)" <?php echo $dis;?>> 
Set Duty Priority for Poling Person
</td></tr>
<tr>
<td  align="left"><font size="2" face="arial">    
<input type=radio value="5"  name=Opt onclick="loadoption(5)" <?php echo $dis;?>>
Exempt Poling Person
</td>
</tr>
<?php
}
if ($roll<=3) //DEO and Above
{
?>
<tr>
<td  align="left"><font size="2" face="arial">
<input type=radio value="6"  name=Opt onclick="loadoption(6)" <?php echo $dis;?>>
Transfer Poling Officer as Counting Supervisor/Assistant
</td></tr>
<?php } ?> 


<tr><td align=right bgcolor=#ccffcc>
</td><td align=left bgcolor=#ccffcc>
<input type=hidden size="1" value="0"  name="Myoption" readonly>
<input type=hidden size="1" value="0"  name="Avl" id="Avl">
    
<input type=button value="Proceed"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;width:100px" disabled>
</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Save");

if($mtype==1)//Postback from Dep_type
echo $objUtility->focus("Depcode");

if($mtype==2)//Postback from Depcode
echo $objUtility->focus("Save");

?>
<?php
include("footer.htm");
?>
</body>
</html>
