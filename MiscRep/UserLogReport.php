<?PHP 
//include("MiscMenuhead.html"); 
?>
<script type="text/javascript" src="../validation.js"></script>
<script language="javascript">
<!--
function validate()
{
if ( DateValid('Mydate',1))
{
//myform.setAttribute("target","_self");//Open in Self
//myform.setAttribute("target","_blank");//Open in New Window
myform.action="ShowUserLogReport.php";
myform.submit();
}
else
{
if (DateValid('Mydate',1)==false)
{
document.getElementById('Mydate').focus();
}
}
}//End Validate

function home()
{
window.location="../mainmenu.php";    
}
//END JAVA
</script>
<script language="JavaScript" src="../datepicker/htmlDatePicker.js" type="text/javascript"></script>
<link href="../datepicker/htmlDatePicker.css" rel="stylesheet"/>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';

$objUtility=new Utility();
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');


if (isset($_SESSION['msg']))
$returnmessage=$_SESSION['msg'];
else
$returnmessage="";

$dt=date('d/m/Y');

//Start of FormDesign
?>
    <p align="center"></p> <p align="center"></p>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=50%>
<form name=myform  method=POST >
<tr>
<td colspan=2 align=Center bgcolor=#66CC66>
<font face=arial size=3>View User Log Report on Particular Date</font>
</td>
</tr>
<?php $i=0; ?>
<?php //row1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Enter Date
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=10 name="Mydate" id="Mydate" value="<?php echo $dt; ?>" onfocus="ChangeColor('Mydate',1)"  onblur="ChangeColor('Mydate',2)">
<img src="../datepicker/images/calendar.png" align="absmiddle" width="25" height="25" onClick="GetDate(Mydate);" alt="Click Here to Pick Date">
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#FFFFCC>
&nbsp;
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:100px";
?>
<input type=button value="Show"  name=Save onclick=validate() style="<?php echo $mystyle;?>">
<input type=button value="Menu"  name=homeq onclick=home() style="<?php echo $mystyle;?>">
</td></tr>
</table>
</form>

</body>
</html>
