<html>
<head>
<title></title>
</head>
<body>
 <?php
session_start();
require_once '../class/utility.class.php';

$objUtility=new Utility();
//$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();

if ($roll==-1) //Not Authorised
{
$_SESSION['returnmsg']="You are not authosied for Bakijai" ; 
header( 'Location: ../index.php?tag=1');    
}
if (isset($_GET['unauth']))  //Check area of authority
echo $objUtility->alert ("Unauthorised Area");
?>
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=40%>
<tr><td colspan=1 align=Center bgcolor=#ccffcc><font face=arial size=4>Miscellaneous Report</font></td></tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Summary.php?tag=0  style='text-decoration: none'>Summary Page</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=SelectCategory.php?tag=0  style='text-decoration: none'>Poll Category Wise Report</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=SelectDeptype.php?tag=0  style='text-decoration: none'>Office Category Wise Polling Person Summary</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Gazeted.php?tag=0  style='text-decoration: none'>Gazeted Officer List</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Exempted.php?tag=0  style='text-decoration: none'>Exempted Person List</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=SelectDesig.php?tag=0  style='text-decoration: none'>Designationwise List</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=../Mainmenu.php?tag=0  style='text-decoration: none'>Home</a>
</td>
</tr>
</table>
</form>
</body>
</html>
