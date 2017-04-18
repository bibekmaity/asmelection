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
<tr><td colspan=1 align=Center bgcolor=#ccffcc><font face=arial size=4>EVM Management Menu</font></td></tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_bu.php?tag=0  style='text-decoration: none'>Entry/Edit Ballot Unit</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_cu.php?tag=0  style='text-decoration: none'>Entry/Edit Control Unit</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=CreateEVMGroup.php?tag=0  style='text-decoration: none'>Create/View LAC Wise EVM Group</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Select4RandomiseEVM.php?tag=0  style='text-decoration: none'>Assign Polling Station Number to EVM Group</a>
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
