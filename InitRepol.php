
<BODY>
    
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once './class/class.Repolgroup.php';
require_once './class/utility.class.php';
require_once './class/class.psname.php';
require_once './class/class.Lac.php';
//require_once './class/class.Poling.php';

$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

if(isset($_POST['Tot']))
$res=$_POST['Tot'];
else
$res=0;


$objTest=new Repolgroup();
$sql="delete from repolgroup";
$objTest->ExecuteQuery($sql);

//  ($laccode);
$objTest->setLac("0");
$grpno=$objTest->maxGrpno();


for($k=0;$k<$res;$k++)
{
$objTest->setGrpno($grpno);
$objTest->setReserve("N");
$objTest->SaveRecord();
//echo $grpno." ".$objTest->returnSql."<br>";
$grpno++;
} 

?>
    
<form name="newform"  method="post">      
<table border=1 cellpadding="2" align=center cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" >
    <tr>
      <td width="100%" align="center"  colspan="7" >
      <font color="BLACK" SIZE="2"><B>REPOL GROUP FORMATION DETAIL</td>
    </tr>
    <tr>
    <td width="15%" align="center" bgcolor="#FFFF33" >
    <font face="Arial" size="2">No & Name of Constituency</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Presiding</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">First <br> Officer</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Second Poling</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33">
      <font face="Arial" size="2">Third Poling</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Forth Poling</font></td>
    <td width="24%" align="center" bgcolor="#FFFF33">
      <font face="Arial" size="2">Click below to View/Clear<br><input type="checkbox" name="mpdf" checked="checked">PDF<br>
      View from<input type="text" name="From" value="1" size="1" >to
       <input type="text" name="To" size="1" value="25" >
      </font></td>
    </TD>
     
     </tr>  
 <tr>
<td align="left"><font face="Arial" size="2"><b>
Repol Group        
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objTest->mySelection(1);?>    
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objTest->mySelection(2);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objTest->mySelection(3);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objTest->mySelection(4);?>   
</td>  
<td align="center">
<?php echo $objTest->mySelection(5);?>
</td>  
<td align="center" width="8%">
<input type=button value="View"  name=but1 onclick=proceed(1)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:60px" >
</td> 
</tr>
<?php   
?>
</form>
</table>       
     