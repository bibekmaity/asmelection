<?php
//include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>

<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function direct1()
{
var i;
i=0;
}
function setMe()
{
myform.Uid.focus();
}

function redirect(i)
{
}

function validate()
{

var a=myform.Uid.value ;// Primary Key
var a_length=parseInt(a.length);
var b=myform.Pwd.value ;
var b_length=parseInt(b.length);
if (a_length>=4 && a==b && notNull(a) && SimpleValidate(a) && a_length<=20 && notNull(b) && SimpleValidate(b) && b_length<=20)
{
myform.action="ChangePassword.php";
myform.submit();
}
else
alert('Invalid Password(At least 4 Character)');
}


function home()
{
window.location="mainmenu.php?tag=1";
}

function logout()
{
window.location="indexPage.php?tag=1";
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
session_start();
//header('Refresh: 1;url=changepwd.php');

require_once './class/utility.class.php';
require_once './class/class.pwd.php';
require_once 'header.php';
//require_once './class/class.copy.php';

//$objCp=new CopyF();

//$objCp->AllFrameExist();
//echo $objCp->Left." ".$objCp->Middle." ".$objCp->Right."<br>";


$objUtility=new Utility();

$allowedroll=4; //Change according to Business Logic

$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Index.php');

$objPwd=new Pwd();

if(isset($_SESSION['uid']))
$uid=$_SESSION['uid'];
else
$uid="";    

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

if (isset($_SESSION['username']))
$username=$_SESSION['username'];
else
$username="";
if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="";//Uid
$mvalue[1]="";//Pwd
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
}//tag=1 [Return from Action form]

if ($_tag==0) //Initial Page Loading
{
$_SESSION['mstr']="Hellow <font color=red size=3 face=arial>".$username."</font>, Please Change Your Password";
$_SESSION['update']=0;
$_SESSION['msg']="";
$mvalue[0]="";//Uid
$mvalue[1]="";//Pwd
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]


//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<form name=myform action=insert_pwd.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3><b><?php echo $_SESSION['mstr']?></b></font><font face=arial color=red size=2>&nbsp;</font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Enter New Password</font></td><td align=left bgcolor=#FFFFCC>
<input type=password size=20 name="Uid" id="Uid" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Uid',1)"  onblur="ChangeColor('Uid',2)" onchange=direct1()>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Re Enter New Password</font></td><td align=left bgcolor=#FFFFCC>
<input type=password size=20 name="Pwd" id="Pwd" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=20 onfocus="ChangeColor('Pwd',1)"  onblur="ChangeColor('Pwd',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr><td align=right bgcolor=#FFFFCC>

</td><td align=left bgcolor=#FFFFCC>
<input type=hidden size=20 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value=Change  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
<?php  if ($objPwd->FirstLogin($uid)=="N")
{?>    
<input type=button value=Menu  name=hm onclick=home()  style="font-family:arial; font-size: 14px ; background-color:red;color:blue;width:100px">
<?php 
}
else
{
echo "&nbsp;"; 
}
?>

</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Uid");

if (strlen($_SESSION['msg'])>0)
echo $objUtility->alert($_SESSION['msg']);


?>
</body>
</html>

