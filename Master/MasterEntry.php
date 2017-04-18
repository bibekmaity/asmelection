<html>
<head>
<title></title>
</head>
<body>
<?php
require_once '../class/utility.class.php';
session_start();
//Start Verify
$objUtility=new Utility();
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify   
if (isset($_GET['unauth']))  //Check area of authority
echo $objUtility->alert ("Unauthorised Area");

?>    
<table border=1 align=center cellpadding=0 cellspacing=0 style=border-collapse: collapse; width=40%>
<tr><td colspan=1 align=Center bgcolor=#ccffcc><font face=arial size=4>Master Data Entry Menu</font></td></tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_hpc.php?tag=0  style='text-decoration: none'>HPC</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_lac.php?tag=0  style='text-decoration: none'>LAC</a>
</td>
</tr>   
    <tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_psname.php?tag=0  style='text-decoration: none'>Poling Station</a>
</td>
</tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_beeo.php?tag=0  style='text-decoration: none'>BEEO Detail</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_designation.php?tag=0  style='text-decoration: none'>Designation</a>
</td>
</tr>

<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_category.php?tag=0  style='text-decoration: none'>Poll Category</a>
</td>
</tr>
<tr>
<td align=center bgcolor=#FFFFCC>
<a href=Form_cell.php?tag=0  style='text-decoration: none'>New Cell</a>
</td>
</tr>

<tr>
<td align=center bgcolor=#FFFFCC>
<a href=../mainmenu.php?tag=0  style='text-decoration: none'>Home</a>
</td>
</tr>
</table>
</form>
</body>
</html>
