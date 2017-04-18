
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.psname.php';
require_once './class/class.repolgroup.php';
require_once './class/class.poling.php';
require_once './class/class.training.php';
require_once './class/class.sentence.php';
require_once './class/class.status.php';
require_once './class/class.final.php';

//RANDOMISATION'

$objPg=new Repolgroup();
$objPoling=new Poling();
$objUtility=new Utility();


$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');


$t2= date('H:i:s');
//echo "start-".$t2;

$success=0;
$fail=0;


if (isset($_POST['Tot']))
$atot=$_POST['Tot'];
else
$atot=0;

if (isset($_POST['Category']))
$b_Category=$_POST['Category'];
else
$b_Category=0;

$mvalue[1]=$b_Category;

$condition=array();

$condition[1]="  Prno=0";    
$condition[2]="  Po1no=0"; 
$condition[3]="  Po2no=0"; 
$condition[4]="  Po3no=0"; 
$condition[5]="  Po4no=0"; 


$total=$objPg->rowCount($condition[$b_Category]);  //Total Officer required  
$cond=" sex='M' and selected='Y' and deleted='N' and  pollcategory=".$b_Category;
$cond=$cond." order by tag desc,rnumber";

$objPg->setCondString("Prno=0  order by grpno") ;   
$row=$objPg->getmyGrpNo();

$objPoling->setCondString($cond);
$mrow=$objPoling->getAllRecord();

if(count($mrow)>=count($row))
{
$i=0;
for ($j=0;$j<count($row);$j++)
{
$grp=$row[$j];
$objPg->setGrpno($grp);
if($b_Category==1)
{
$objPg->setPrno($mrow[$i]['Slno']);
$objPg->setDcode($mrow[$i]['Depcode']);
}
if($b_Category==2)
{
$objPg->setPo1no($mrow[$i]['Slno']);
$objPg->setDcode1($mrow[$i]['Depcode']);
}
if($b_Category==3) //second poling
{
$objPg->setPo2no($mrow[$i]['Slno']);
$objPg->setDcode2($mrow[$i]['Depcode']);
}

if($b_Category==4) //second poling
{
$objPg->setPo3no($mrow[$i]['Slno']);
$objPg->setDcode3($mrow[$i]['Depcode']);
}

if($b_Category==5) //second poling
{
$objPg->setPo4no($mrow[$i]['Slno']);
$objPg->setDcode4($mrow[$i]['Depcode']);
}

if ($objPg->UpdateRecord())
{
$success++;
$i++;
} //$objPg->UpdateRecord
} //for loop
}//if

//END NEW CODE 11 JULY
echo "Selected ".$success." ".$objUtility->CategoryList[$b_Category];
?>
<form name="newform"  method="post">      
<table border=1 cellpadding="2" align=center cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" >
    <tr>
      <td width="100%" align="center"  colspan="8" >
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
    <td width="24%" align="center" bgcolor="#FFFF33" colspan="2">
      <font face="Arial" size="2">Click below to View
            </font></td>
    </TD>
     
     </tr>  
 <tr>
<td align="left"><font face="Arial" size="2"><b>
Repol Group        
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(1);
?>    
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(2);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(3);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(4);?>   
</td>  
<td align="center">
<?php echo $objPg->mySelection(5);?>
</td>  
<td align="center" width="8%">
<input type=button value="Group"  name=but1 onclick=proceed(1)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:100px" disabed>
</td> 
<td align="center" width="8%">
<input type=button value="Appointment"  name=but2 onclick=proceed(2)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:100px" >
</td> 
</tr>
<?php   
?>
</form>
</table>       
      
   
</body></html>
