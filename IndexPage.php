<html>
<head>
<title>User Login Form</title>
</head>

<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
//document.getElementById('Uid').focus();
}); //Ready Function
</script> 

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

function redirect()
{
var data="Uid="+document.getElementById('Uid').value;
data=data+"&Pwd="+document.getElementById('Pwd').value;
//if(StringValid('Uid',1) && StringValid('Pwd',1) )
//{
MyAjaxFunction("POST","PreVerify.php",data,"DivMsg","TEXT");    
MyAjaxFunction("POST","PreVerify.php?mtype=1",data,"Result","TEXT");    
//MyAjaxFunction("POST","PreVerify.php?mtype=3",data,"Star","HTML");    
//}
}

function FrameTest()
{
var data="Uid="+document.getElementById('Uid').value;    
MyAjaxFunction("POST","PreVerify.php?mtype=2",data,"DivButton","HTML");    
}

function validate()
{

var a=myform.Uid.value ;
var a_length=parseInt(a.length);
var b=myform.Pwd.value ;
var b_length=parseInt(b.length);
var ok=parseInt(document.getElementById('Result').value);
if(ok==0)
{
if ( notNull(a) && validateString(a) && a_length<=20 && notNull(b) && SimpleValidate(b) && b_length<=30)
{
document.getElementById('DivButton').innerHTML="<image src=./image/star.gif width=30 height=30>";
myform.action="verify.php";
myform.submit();
}
else
alert('Invalid Data');
}
else //ok!=0
{ 
var Err=document.getElementById('DivMsg').value;    
if(Err.length==0)
Err="Click Again" ;   
alert(Err) ;   
document.getElementById('Pwd').value="";
document.getElementById('Pwd').focus();
var tr=parseInt(document.getElementById('trial').value)+1;
document.getElementById('trial').value=tr;
if(tr>5)
{
document.getElementById('DivButton').innerHTML="Maximum Trial Exceed"; 
document.getElementById('Uid').disabled=true;
document.getElementById('Pwd').disabled=true;
}  
}
}


function home()
{
window.location="mainmenu.php?tag=1";
}



</script>
<body >
<?php
session_start();

//Set the Path for Access Database Backup
$_SESSION['backuppath']=realpath("Election.mdb");

//require_once './class/class.columns.php';
//$objCol=new Columns();
require_once './class/class.userlog.php';

require_once './class/utility.php';
require_once './class/utility.class.php';
require_once './class/class.checktable.php';

require_once './class/class.Frame.php';
$objF=new Frame();
$objF->copyFooter();

//$objUtility=new myutility();

$_SESSION['New']=1;

$objUtility=new Utility();
if($objUtility->MyIP()==true)
$objF->CopyUtility();

$Tcheck=new Checktable();
$dis="";
$error=0;
$_SESSION['error']=false;

$rd="";

date_default_timezone_set("Asia/kolkata");

$objUl=new Userlog();
 
if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];
else
$ip="-";
$sql="update userlog set Active='N'";
$sql=$sql." where Client_ip='".$ip."' or Log_date<'".date('Y-m-d')."'";
$objF->ExecuteQuery($sql);


if($Tcheck->Result >0)
{
echo $objUtility->alert($Tcheck->Result." Table Doesnot Exist") ;   
$dis=" disabled";
$_SESSION['catchmessage']=$Tcheck->Result." Table Doesnot Exist(Wait for Creation)";
$_SESSION['error']=true;
header( 'Location: ExecuteScript.php');
}


if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if(!is_numeric($_tag) || $_tag>2)
$_tag=0;


if($_tag==2)
{
//session_unset;
if(isset($_SESSION['msg']))
echo $objUtility->alert($_SESSION['msg']) ;
if(isset($_SESSION['mvalue']))  
unset($_SESSION['mvalue']) ;  
$dis=" disabled";
$objUtility->saveTextLog("UserLog","Session Locked ".date('H:i:s'));
}


if ($_tag==0)
{
$mvalue[0]="";
$mvalue[1]="";
$_SESSION['msg']="";
if (isset($_SESSION['uid']))
unset($_SESSION['uid']) ;
}
else
{
if(isset($_SESSION['mvalue']))    
$mvalue=$_SESSION['mvalue'];
else
{
$mvalue[0]="";
$mvalue[1]="";
$_SESSION['msg']="";    
}    
}//$tag==0


if($_tag==1) //LogOFF
{
$_SESSION['New']=0;
$mvalue[0]="";    
if (isset($_SESSION['uid']))
{
$mvalue[0]=$_SESSION['uid'];
unset($_SESSION['uid']) ;
}
$_SESSION['t2']=date('H:i:s');
if(isset($_SESSION['mvalue']))  
unset($_SESSION['mvalue']) ;   
$rd=" readonly ";
$mvalue[1]="";
}//tag==1


//$_SESSION['msg']="Failed to Login";
//header( 'Location: index.php?tag=2');

if (isset($_GET['msg']))
$msg=$_GET['msg'];
else
$msg="";


//Start of Form Design


if(isset($_SESSION['msg']))
$msg= $_SESSION['msg'];   

?>
<div style='position:relative;width:100%'>
<table border="0" CELLPADDING="0" width="100%" align="center" >
<tr>
<td align="center" colspan="3" width="100%">
<?php if(1==1) {?>
<image src="./image/header.jpg" width="735px" height="70px">                
<?php 
}?>
<?php if(1==2) {?>
<image src="./image/election.jpg" width="95%" height="70px"> 
<?php 
}?>
</td>
</tr>    
<tr>
<td align="center" colspan="3" width="100%">
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=50%>
<form name=myform action=verify.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#66CC66 VALIGN="CENTER"><font face=arial size=3>USER LOGIN FORM<br></font><font face=arial color=red size=2>
  <input type="hidden" name="DivMsg" id="DivMsg"  size="8" value="Try Again">          
       </font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFF66><font color=black size=2 face=arial><B>Enter User ID</font></td><td align=left bgcolor=#FFFF66>
<input type=text size=10 name=Uid id="Uid" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black;font-weight:bold; font-size: 14px" maxlength=20 onblur="RemoveSpace('Uid');FrameTest();redirect()"  <?php echo $dis;?> <?php echo $rd;?>>
<input type=hidden size=1 name=Result id="Result" value="10">
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFF66><font color=black size=2 face=arial><B>Enter Password</font></td><td align=left bgcolor=#FFFF66>
<input type=password size=10 name=Pwd id="Pwd" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black;font-weight:bold; font-size: 14px" maxlength=15 onkeyup="redirect()" <?php echo $dis;?>>
<input type="hidden" size="1" name="trial" id="trial" value="0">    
</td>
</tr>
<?php $i++; //Now i=2?>
<tr><td align=right bgcolor=#66CC66>&nbsp;
</td><td align=left bgcolor=#66CC66>
<div id="DivButton">   
<input type=button value=Login  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:#FF9999;color:black;width:80px" <?php echo $dis;?>>
</div>
    
</td></tr>
</table>
</TD></TR>
</TABLE>  
</div>  
</form>
 <?php
//echo "Rtag".$_tag;
if($_tag=="0")
echo $objUtility->focus("Uid");
if($_tag=="1")
echo $objUtility->focus("Pwd");
?>      
   </body>
</html>
