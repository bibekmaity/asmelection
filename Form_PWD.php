<?PHP 
include("Menuhead.html"); 
?>
<script type="text/javascript" src="validation.js"></script>
<script language="javascript">
<!--

function res()
{
//alert('ok');
myform.action="Form_pwd.php?tag=0";
myform.submit();
}


function upd()
{
if(myform.ResP.checked==true)
{
b=myform.Uid.value;
myform.Pwd.value=myform.Uid.value;    
alert('Password will be set as '+b);
}
}



function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Uid.value=mvalue;

var b=myform.Uid.value ;//Primary Key
if ( b!="")
{
myform.action="Form_pwd.php?tag=2&ptype=0";
myform.submit();
}
}

function direct1()
{
var data="Uid="+document.getElementById('Uid').value;
MyAjaxFunction("POST","PreVerifyID.php",data,"DivMsg","HTML");    
}

function setMe()
{
myform.Fullname.focus();
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
//window.location="mainmenu.php?tag=1";
var a=myform.Fullname.value ;
var a_length=parseInt(a.length);
var b=myform.Uid.value ;// Primary Key
var b_length=parseInt(b.length);
var c=myform.Pwd.value ;
var c_length=parseInt(c.length);
var d=myform.Roll.value ;
var d_index=myform.Roll.selectedIndex;
var e=myform.Active.value ;
if (validateString(a) && a_length<=50 && notNull(b) && validateString(b) && b_length<=20 && notNull(c) && SimpleValidate(c) && c_length<=20  && d_index>0 )
{
if(c_length<4)
alert('Password should be at least 4 character');
else
{    
myform.action="Insert_pwd.php";
myform.submit();
}
}
else
alert('Invalid Data');
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
header('Refresh: 60;url=IndexPage.php?tag=1');
session_start();
require_once './class/utility.class.php';
require_once './class/class.pwd.php';
require_once './class/class.roll.php';

$objUtility=new Utility();
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

$objPwd=new Pwd();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>2)
$_tag=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if (!is_numeric($mtype))
$mtype=0;

$present_date=date('d/m/Y');
$mvalue=array();
$pkarray=array();
$readonly=" ";
if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[5]=0;
}
else
{
$mvalue[0]="";//Fullname
$mvalue[1]="";//Uid
$mvalue[2]="";//Pwd
$mvalue[3]="0";//Roll
$mvalue[4]="";//Active
$mvalue[5]=0;
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
$mvalue[0]="";//Fullname
$mvalue[1]="";//Uid
$mvalue[2]="";//Pwd
// Call $objPwd->MaxRoll() Function Here if required and Load in $mvalue[3]
$mvalue[3]="0";//Roll
$mvalue[4]=1;//Active
$mvalue[5]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Uid']))
$pkarray[0]=$_POST['Uid'];
else
$pkarray[0]=0;
$objPwd->setUid($pkarray[0]);
if ($objPwd->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$readonly=" readonly";    
$mvalue[0]=$objPwd->getFullname();
$mvalue[1]=$objPwd->getUid();
$mvalue[2]=$objPwd->getPwd();
$mvalue[3]=$objPwd->getRoll();
$mvalue[4]=$objPwd->getActive();
$mvalue[5]=$mvalue[1];//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]="";
$mvalue[1]=$pkarray[0];
$mvalue[2]="";
$mvalue[3]=-1;
$mvalue[4]=1;
$mvalue[5]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=70%>
<form name=myform action=insert_pwd.php  method=POST >
<tr>
<td colspan=2 align=Center bgcolor=#ccffcc>
<font face=arial size=3><b>User Management Form</b><br></font>
<font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font>
</td>
</tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Name of User
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=50 name="Fullname" id="Fullname" value="<?php echo $mvalue[0]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Fullname',1)"  onblur="ChangeColor('Fullname',2)">
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
User ID
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=20 name="Uid" id="Uid" value="<?php echo $mvalue[1]; ?>" style="<?php echo $mystyle;?>"  maxlength=20 onfocus="ChangeColor('Uid',1)"  onblur="ChangeColor('Uid',2);RemoveSpace('Uid')" onkeyup="direct1()" <?php echo $readonly;?>>

</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Password(Min 4 Character)
</font>
</td>
<td align=left bgcolor=#FFFFCC><font color=black size=2 face=arial>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=password size=20 name="Pwd" id="Pwd" value="<?php echo $mvalue[2]; ?>" style="<?php echo $mystyle;?>"  maxlength=20 onfocus="ChangeColor('Pwd',1)"  onblur="ChangeColor('Pwd',2)" <?php echo $readonly;?>>
<font color=red size=3 face=arial>*</font>
<?php if ($_SESSION['update']==1){?>
<input type=checkbox name=ResP  onclick="upd()">
<?php 
echo  "Reset Password as User ID";
}?>

</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Select Role
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family: Arial;background-color:white;color:black;font-size: 14px;width:160px";
$objRoll=new Roll();
$objRoll->setCondString(" Roll>".$roll); //Change the condition for where clause accordingly
$row=$objRoll->getRow();
?>
<select name=Roll style="<?php echo $mystyle;?>" onchange=redirect(4)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind][0];  //Roll
$mdetail=$row[$ind][1]; //Description
if ($mvalue[3]==$mcode)
{
?>
<option selected value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
else
{
?>
<option  value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
} //for loop
?>
</select>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Check to Activate
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<?php if ($mvalue[4]==false){?>
<input type=checkbox name=Active  value=Sel>
<?php } else{?>
<input type=checkbox name=Active  value=Sel checked=checked>
<?php } ?>
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=#ccffcc>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=blue>Update Mode";
else
echo"<font size=2 face=arial color=blue>Creation Mode";
?>
</td>
<td align=left bgcolor=#ccffcc>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:160px";
$mystyle1="font-family:arial; font-size: 14px ;font-weight:bold; background-color:green;color:black;width:160px";
?>
<div id="DivMsg">
<font color=red size=4 face=arial><b>
<input type=button value="Create/Update User"  name=Save onclick=validate() style="<?php echo $mystyle;?>">
<input type=button value="Reset Form"  name=RES onclick=res() style="<?php echo $mystyle1;?>">
</b></font>
</div>
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
</td></tr>
<tr><td align=right>
<?php 
$objPwd->setCondString(" Roll>".$roll);
 //Change the condition for where clause accordingly
$row=$objPwd->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[5]==$row[$ind][0])
{
?>
<option selected value="<?php echo $row[$ind][0];?>"><?php echo $row[$ind][1];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind][0];?>"><?php echo $row[$ind][1];
}
} //for loop
?>
</select>
</td><td align=left>
<input type=button value=Edit  name=edit1 onclick=direct()  disabled>
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Fullname");

if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);
?>
</body>
</html>
