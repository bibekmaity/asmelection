<html>
<head>
<title>Set New Password</title>
</head>
<script type="text/javascript" src="../validation.js"></script>
<script language="javascript">
<!--


function validate()
{
    
var mn=myform.Pwd.value;
var ln=mn.length;
//StringValid('a',0,0) 'a'- Input Box Id, First(0- Allow Null,1- Not Null) Second(0- Simple Validation, 1- Strong Validation)
if ( StringValid('Pwd1',1,0) && StringValid('Pwd',1,0) && StringValid('Fullname',1,0) &&  StringValid('Ip',1,0) )
{
if(document.getElementById('Pwd').value==document.getElementById('Pwd1').value && ln>=4)
{
myform.action="UpdateFirstPwd.php";
myform.submit();
}
else
alert('Both Password should be same and Minimum 4 character long');    
}
else
{
if (StringValid('Pwd',1,0)==false)//0-Simple Validation
{
alert('Check Pwd');
document.getElementById('Pwd').focus();
}
else if (StringValid('Fullname',1,0)==false)//0-Simple Validation
{
alert('Check Full Name of User');
document.getElementById('Fullname').focus();
}
else if (StringValid('Ip',1,0)==false)//0-Simple Validation
{
alert('Check IP');
document.getElementById('Ip').focus();
}
else 
alert('Enter Correct Data');
}
}//End Validate



//change the focus to Box(a)
function ChangeFocus(a)
{

}


//END JAVA
</script>


<body>
<?php
//Start FORMBODY
session_start();
require_once 'utility.class.php';
require_once 'class.pwd.php';
require_once 'header.php';


$objPwd=new Pwd();


$_tag=0;


$mvalue=array();

if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$mvalue=InitArray();
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]


$returnmessage="";

$mvalue=VerifyArray($mvalue);

//Start of FormDesign
?>
    <p align="center"></p>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>
<form name=myform action=insert_pwd.php  method=POST >
<tr>
<td colspan=2 align=Center bgcolor=#66CC66>
<font face=arial size=3>Set First Time Password for root User</font>
</td>
</tr>
<?php $i=0; ?>
<?php //row1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
User ID
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=20 name="Uid" id="Uid" value="<?php echo $mvalue[0]; ?>" style="<?php echo $mystyle;?>"  maxlength=20 onfocus="ChangeColor('Uid',1)"  onblur="ChangeColor('Uid',2)" onchange=direct1() disabled>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<?php //row2?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Password(Minimum 4 Character)
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=password size=20 name="Pwd" id="Pwd" value="<?php echo $mvalue[1]; ?>" style="<?php echo $mystyle;?>"  maxlength=20 onfocus="ChangeColor('Pwd',1)"  onblur="ChangeColor('Pwd',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Re Enter Password
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=password size=20 name="Pwd1" id="Pwd1" value="<?php echo $mvalue[1]; ?>" style="<?php echo $mystyle;?>"  maxlength=20 onfocus="ChangeColor('Pwd1',1)"  onblur="ChangeColor('Pwd1',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=2?>
<?php //row3?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Name of First User
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=30 maxlength="30" name="Fullname" id="Fullname" value="<?php echo $mvalue[2]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Fullname',1)"  onblur="ChangeColor('Fullname',2)" disabled>
</td>
</tr>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
IP Address of System Manager's Machine
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=30 maxlength="20" name="Ip" id="Ip" value="<?php echo $mvalue[3]; ?>" style="<?php echo $mystyle;?>"  maxlength=20 onfocus="ChangeColor('Ip',1)"  onblur="ChangeColor('Ip',2)">
(Optional) 
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=#FFFFCC>

</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:140px";
?>
<input type=button value="Set Password"  name="Save" id="Save" onclick=validate() style="<?php echo $mystyle;?>">
</td></tr>
</table>
    <p align="center">
        
<image src="../image/NIC.png" width="270px" height="60px" >       
    </p>    
</form>
<?php



//This function will Initialise Array
function InitArray()
{
$temp=array();
$temp[0]="root";//Uid
$temp[1]="";//Pwd
$temp[2]="System Manager";//Fullname
if (isset($_SERVER['REMOTE_ADDR']))
$temp[3]=$_SERVER['REMOTE_ADDR'];
else
$temp[3]="";
return($temp);
}//GenInitArray


//Verify If all Array Index are loaded
function VerifyArray($myvalue)
{
$temp=array();
for($i=0;$i<=3;$i++)
{
$temp[$i]="0";
}

if(isset($myvalue[0]))
$temp[0]=$myvalue[0];

if(isset($myvalue[1]))
$temp[1]=$myvalue[1];

if(isset($myvalue[2]))
$temp[2]=$myvalue[2];

if(isset($myvalue[3]))
$temp[3]=$myvalue[3];

return($temp);
}//VerifyArray

?>
</body>
</html>
