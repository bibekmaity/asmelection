<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>
<script language="javascript">
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
//var j1=myform.rollno.selectedIndex;//Returns Numeric Index from 0
//var j2=myform.box1.checked;//Return true if check box is checked
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="mainmenu.php?tag=1";
var a=myform.Uid.value ;
var a_index=myform.Uid.selectedIndex;
var c=myform.Log_time_in.value ;
var c_length=parseInt(c.length);
var d=myform.Log_time_out.value ;
var d_length=parseInt(d.length);
var e=myform.Client_ip.value ;
var e_length=parseInt(e.length);
var f=myform.Session_id.value ;// Primary Key
if ( notNull(a) && a_index>0  && 1==1 && notNull(c) && validateString(c) && c_length<=15 && notNull(d) && validateString(d) && d_length<=15 && notNull(e) && validateString(e) && e_length<=30 && isNumber(f)==true  )
{
//myform.setAttribute("target","_self");//Open in Self
//myform.setAttribute("target","_blank");//Open in New Window
myform.action="Insert_userlog.php";
myform.submit();
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
session_start();
require_once './class/utility.class.php';
require_once './class/class.userlog.php';
require_once './class/class.pwd.php';

$objUtility=new Utility();
$allowedroll=-1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: index.php');

$objUserlog=new Userlog();

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

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="";//Uid
$mvalue[1]="";//Log_time_in
$mvalue[2]="";//Log_time_out
$mvalue[3]="";//Client_ip
$mvalue[4]="0";//Session_id
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
$mvalue[0]="";//Uid
$mvalue[1]="";//Log_time_in
$mvalue[2]="";//Log_time_out
$mvalue[3]="";//Client_ip
// Call $objUserlog->MaxSession_id() Function Here if required and Load in $mvalue[4]
$mvalue[4]="0";//Session_id
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]


//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<form name=myform action=insert_userlog.php  method=POST >
<tr>
<td colspan=2 align=Center bgcolor=#ccffcc>
<font face=arial size=3>Entry Form for Userlog<br></font>
<font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font>
</td>
</tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Uid
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family: Arial;background-color:grey;color:blue;font-size:12px;font-weight:BOLD;width:160px";
$objPwd=new Pwd();
$objPwd->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objPwd->getRow();
?>
<select name=Uid style="<?php echo $mystyle;?>" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind][0];
$mdetail=$row[$ind][1];
if ($mvalue[0]==$mcode)
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
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Log_time_in
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;background-color:white;color:black; font-size: 22px";
?>
<input type=text size=15 name="Log_time_in" id="Log_time_in" value="<?php echo $mvalue[1]; ?>" style="<?php echo $mystyle;?>"  maxlength=15 onfocus="ChangeColor('Log_time_in',1)"  onblur="ChangeColor('Log_time_in',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Log_time_out
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;background-color:white;color:black; font-size: 12px";
?>
<input type=text size=15 name="Log_time_out" id="Log_time_out" value="<?php echo $mvalue[2]; ?>" style="<?php echo $mystyle;?>"  maxlength=15 onfocus="ChangeColor('Log_time_out',1)"  onblur="ChangeColor('Log_time_out',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Client_ip
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;background-color:white;color:black; font-size: 12px";
?>
<input type=text size=30 name="Client_ip" id="Client_ip" value="<?php echo $mvalue[3]; ?>" style="<?php echo $mystyle;?>"  maxlength=30 onfocus="ChangeColor('Client_ip',1)"  onblur="ChangeColor('Client_ip',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Session_id
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;background-color:white;color:black; font-size: 12px";
?>
<input type=text size=8 name="Session_id" id="Session_id" value="<?php echo $mvalue[4]; ?>" onfocus="ChangeColor('Session_id',1)"  onblur="ChangeColor('Session_id',2)" onchange=direct1()>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=#FFFFCC>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:100px";
?>
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value=Save/Update  name=Save onclick=validate() style="<?php echo $mystyle;?>">
<input type=button value=Menu  name=back1 onclick=home() onfocus="ChangeFocus('Uid')" style="<?php echo $mystyle;?>">
</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Uid");

if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);
?>
</body>
</html>
