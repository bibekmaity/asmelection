<?php
include("EVMMenuhead.html");
?>
<script type="text/javascript" src="../Validation.js"></script>

<script language=javascript>
<!--
function verify()
{
var data="Code="+document.getElementById('Cu_number').value;
MyAjaxFunction("POST","VerifyDuplicate.php?Param=C",data,"Result","HTML");
}

function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Cu_code.value=mvalue;

var a=myform.Cu_code.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="Form_cu.php?tag=2&ptype=0";
myform.submit();
}
}

function direct1()
{
var i;
i=0;
}

function setMe()
{
myform.Cu_code.focus();
}

function redirect(i)
{
}

function validate()
{
//var j1=myform.rollno.selectedIndex;//Returns Numeric Index from 0
//var j2=myform.box1.checked;//Return true if check box is checked
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="EVMMenu.php?tag=1";
var a=myform.Cu_code.value ;// Primary Key
var b=myform.Cu_number.value ;
var b_length=parseInt(b.length);
var c=myform.Trunck_number.value ;
if ( isNumber(a)==true   && notNull(b) && validateString(b) && b_length<=20 && 1==1)
{
myform.action="Insert_cu.php";
myform.submit();
}
else
alert('Invalid Data');
}


function home()
{
window.location="EVMMenu.php?tag=1";
}

function LoadTextBox()
{
var i=myform.Editme.selectedIndex;
if(i>0)
myform.edit1.disabled=false;
else
myform.edit1.disabled=true;
//alert('Write Java Script as per requirement');
}

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once './class/class.cu.php';

$objUtility=new Utility();
$trg="";
//Start Verify
$allowedroll=3; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$objCu=new Cu();

$sel1="";
$sel2="";

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>2)
$_tag=0;
$lock=" readonly";
if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if (!is_numeric($mtype))
$mtype=0;

$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[3]=0;
$mvalue[0]=$objCu->MaxCu_code();//Cu_code
}
else
{
$mvalue[0]="0";//Cu_code
$mvalue[1]="";//Cu_number
$mvalue[2]="0";//Trunck_number
$mvalue[3]=0;
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
}//tag=1 [Return from Action form]

if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objCu->MaxCu_code() Function Here if required and Load in $mvalue[0]
$mvalue[0]=$objCu->MaxCu_code();//Cu_code
$mvalue[1]="";//Cu_number
// Call $objCu->MaxTrunck_number() Function Here if required and Load in $mvalue[2]
$mvalue[2]="0";//Trunck_number
$mvalue[3]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Cu_code']))
$pkarray[0]=$_POST['Cu_code'];
else
$pkarray[0]=0;
$objCu->setCu_code($pkarray[0]);
if ($objCu->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objCu->getCu_code();
$mvalue[1]=$objCu->getCu_number();
$mvalue[2]=$objCu->getTrunck_number();
$mvalue[3]=0;//last Select Box for Editing
if($objCu->getUsed()=="T")
$trg=" checked=checked";
else
$trg="";
if($objCu->getCategory()==1)
{
$sel1=" Selected ";
$sel2="  ";
}
if($objCu->getCategory()==2)
{
$sel1=" ";
$sel2=" Selected ";
}
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]="";
$mvalue[2]="";
$mvalue[3]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=55%>
<form name=myform action=insert_cu.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for Control Unit<br></font><font face=arial color=red size=2>
<?php echo  $_SESSION['msg'] ?>
</font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Serial</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Cu_code" id="Cu_code" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Cu_code',1)"  onblur="ChangeColor('Cu_code',2)" onchange=direct1() <?php echo $lock;?>>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Control Unit Number</font></td><td align=left bgcolor=white>
<input type=text size=20 name="Cu_number" id="Cu_number" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Cu_number',1)"  onblur="ChangeColor('Cu_number',2)" onkeyup="verify()">
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Trunck Number</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Trunck_number" id="Trunck_number" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Trunck_number',1)"  onblur="ChangeColor('Trunck_number',2)">
</td>
</tr>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Mark for Training</font></td><td align=left bgcolor=white>
<input type=checkbox name="Trg" id="Trg" <?php echo $trg;?>>
</td>
</tr>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select EVM Category</font></td>
<td align=left bgcolor=white>
<select name="Cat" id="Cat">
<option value="1" <?php echo $sel1;?>>Category-1
<option value="2" <?php echo $sel2;?>>Category-2    
    </select>
</td>
</tr>
<?php $i++; //Now i=3?>
<tr><td align=right bgcolor=white>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td><td align=left bgcolor=white><font face=arial size=2 color=red>
<div id="Result">
<?php
if ($_SESSION['update']==1)
{
?>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
<?php
}
?>
</div>
</font>
</td></tr>
<tr><td align=right>
<?php 
$objCu->setCondString("1=1 order by trunck_number,cu_number" ); //Change the condition for where clause accordingly
$row=$objCu->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$cat=" (Cat-".$row[$ind]['Category'].")" ;     
if ($mvalue[$i]==$row[$ind]['Cu_code'])
{
?>
<option selected value="<?php echo $row[$ind]['Cu_code'];?>">[<?php echo $row[$ind]['Trunck_number'];?>]&nbsp;<?php echo $row[$ind]['Cu_number'].$cat;?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Cu_code'];?>">[<?php echo $row[$ind]['Trunck_number'];?>]&nbsp;<?php echo $row[$ind]['Cu_number'].$cat;
}
} //for loop
?>
</select>
</td><td align=left>
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Cu_number");

?>
<?php
include("footer.htm");
?>
</body>
</html>
