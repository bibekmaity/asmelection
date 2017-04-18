<html>
<head><title>Reserve selection</title></head>
<script language=javascript>
<!--
function validate()
{
var a=myform.Calldate.selectedIndex;
var pr=myform.Pr.value;
var p1=myform.P1.value;
var p2=myform.P2.value;
var p3=myform.P3.value;
var p4=myform.P4.value;


if (isNumber(pr) && isNumber(p1) && isNumber(p2) && isNumber(p3) && isNumber(p4))
j=Number(pr)+Number(p1)+Number(p2)+Number(p3)+Number(p4);
else
j=0;

if (j>0 && a>0)
{
myform.action="SelectReserve.php?tag=1";
myform.submit();
}
else
alert('Invalid Selection');
}
function home()
{
  window.location="randmenu.php";  
}

function notNull(str)
{
var k=0;
var found=false;
var mylength=str.length;
for (var i = 0; i < str.length; i++) 
{  
k=parseInt(str.charCodeAt(i)); 
if (k!=32)
found=true;
}
return(found);
}

function isNumber(ad)
{
if (isNaN(ad)==false && notNull(ad))
return(true);
else
return(false);
}

function ChangeColor(el,i)
{
if (i==1) // on focus
document.getElementById(el).style.backgroundColor = '#99CC33';
if (i==2) //on lostfocus
{
document.getElementById(el).style.backgroundColor = 'white';
var temp=document.getElementById(el).value;
}

}

</script>
<BODY>
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.polinggroup.php';
require_once './class/class.party_calldate.php';
require_once './class/class.psname.php';

$objPg=new Polinggroup();
$objPoling=new Poling();
$objPdate=new Party_calldate();
$objPs=new Psname();

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Randmenu.php?unauth=1');
//End Verify

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>3)
$_tag=0;

if ($_tag==1) //Do selection for reserve
{
if (isset($_POST['Calldate']))
$Calldate=$_POST['Calldate'];
else
$Calldate=0;    
  
$catg=array();

$catname=array(1=>'Presiding',2=>'First Poling',3=>'Second Poling',4=>'Third poling',5=>'Forth Poling');

if (isset($_POST['Pr']))
$catg[1]=$_POST['Pr'];
else
$catg[1]=0;

if (isset($_POST['P1']))
$catg[2]=$_POST['P1'];
else
$catg[2]=0;

if (isset($_POST['P2']))
$catg[3]=$_POST['P2'];
else
$catg[3]=0;

if (isset($_POST['P3']))
$catg[4]=$_POST['P3'];
else
$catg[4]=0;

if (isset($_POST['P4']))
$catg[5]=$_POST['P4'];
else
$catg[5]=0;

$maxps=$objPs->recordCount;

$condition=" reserve='Y'";
$lastgrp=$objPg->rowCount($condition);
if ($lastgrp==0)
{
$lastgrp=$maxps+1;    
}
else
$lastgrp=$maxps+$lastgrp+1; 

$msg="Selected ";

//Presiding
for ($ind=1;$ind<=5;$ind++) //loop through category
{
//echo $ind."<br>";
$a=0;
$cond="pollcategory=".$ind." and selected='N' and grpno=0 and deleted='N' and sex='M'" ;
if (isset($_POST['trg']))
$cond=$cond." and Slno in(select Poling_id from poling_training where phaseno=1 and (attended1='Y' or attended2='Y' or attended3='Y'))";

$objPoling->setCondString($cond);

$row=$objPoling->getSelectedRow($catg[$ind]);
//echo $objPoling->returnSql."<br>";
//echo $catname[$ind]." ".$catg[$ind]."-Found".count($row)."<br>";

for ($i=0;$i<count($row);$i++)
{
 //echo $row[$i]['Slno']."<br>";
$objPg->setGrpno($lastgrp);
$objPg->setLac("0");
$objPg->setAdvance($Calldate);
$objPg->setLarge("0");
$objPg->setReserve("Y");
if ($ind==1)
{    
$objPg->setPrno($row[$i]['Slno']);
$objPg->setDcode($row[$i]['Depcode']);
}
else
{
$objPg->setPrno("0");
$objPg->setDcode("0");   
}

if ($ind==2)
{    
$objPg->setPo1no($row[$i]['Slno']);
$objPg->setDcode1($row[$i]['Depcode']);
}
else
{
$objPg->setPo1no("0");
$objPg->setDcode1("0");   
}

if ($ind==3)
{    
$objPg->setPo2no($row[$i]['Slno']);
$objPg->setDcode2($row[$i]['Depcode']);
}
else
{
$objPg->setPo2no("0");
$objPg->setDcode2("0");   
}

if ($ind==4)
{    
$objPg->setPo3no($row[$i]['Slno']);
$objPg->setDcode3($row[$i]['Depcode']);
}
else
{
$objPg->setPo3no("0");
$objPg->setDcode3("0");   
}

if ($ind==5)
{    
$objPg->setPo4no($row[$i]['Slno']);
$objPg->setDcode4($row[$i]['Depcode']);
}
else
{
$objPg->setPo4no("0");
$objPg->setDcode4("0");   
}

if ($objPg->SaveRecord())
{
$sql="update poling set grpno=".$lastgrp.",selected='R' where slno=".$row[$i]['Slno'];   
if ($objPg->ExecuteQuery($sql))
$a++;
$lastgrp++;

if (isset($_POST['mylog']))
{    
$objUtility->saveSqlLog("ReserveSelection", $objPg->returnSql);
$objUtility->saveSqlLog("ReserveSelection", $sql);
} //isset[mylog]
}  //if
//echo $objPg->returnSql."<br>";
} //for loop for Presiding

if ($a>0)
$msg=$msg." ".$a." ".$catname[$ind]."! ";

} //for loop for Category




echo $objUtility->alert($msg);

}//$tag==1




?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform   method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Selection of Reserve Poling Person<br></font><font face=arial color=red size=2><?php //echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Reporting Date</font></td><td align=left bgcolor=#FFFFCC>
<?php 
$row=$objPdate->getRow();
?>
<select name=Calldate style="font-family: Arial;background-color:white;color:black; font-size: 14px">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
$condition=" pollcategory=1 and selected='N' and sex='M' and deleted='N'";
$pr=$objPoling->rowCount($condition);
$condition=" pollcategory=2 and selected='N' and sex='M' and deleted='N'";
$p1=$objPoling->rowCount($condition);
$condition=" pollcategory=3 and selected='N' and sex='M' and deleted='N'";
$p2=$objPoling->rowCount($condition);
$condition=" pollcategory=4 and selected='N' and sex='M' and deleted='N'";
$p3=$objPoling->rowCount($condition);
$condition=" pollcategory=5 and selected='N' and sex='M' and deleted='N'";
$p4=$objPoling->rowCount($condition);

?>
</select>
<font color=blue size=2 face=arial>
<input type="checkbox" name="trg" checked=checked>
Prefer Training Attendance
</font>&nbsp&nbsp;
<font face="arial" size="2">
<input type="checkbox" name="mylog" disabled>
</td>
</tr>    
<tr>
<td align=center bgcolor=#66FFCC colspan="2"><font face=arial size=2>Enter Total Reserve for Each Category</font></td>
</td></tr>
<tr><td colspan="2" align="center">
<table border="1" width="95%" align="center">
<tr>
<td align="center" width="25%"><font color=blue size=2 face=arial>&nbsp;</td>    
<td align="center" width="15%"><font color=blue size=2 face=arial><B>Presiding</td>
<td align="center" width="15%"><font color=blue size=2 face=arial><B>Poling-1</td>
<td align="center" width="15%"><font color=blue size=2 face=arial><B>Poling-2</td>
<td align="center" width="15%"><font color=blue size=2 face=arial><B>Poling-3</td>
<td align="center" width="15%"><font color=blue size=2 face=arial><B>Poling-4</td>
</tr>
<tr>
<td align="center" width="25%" ><font color=blue size=2 face=arial>Available for Selection</td>    
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $pr;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p1;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p2;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p3;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p4;?></td>
</tr>
<?php for($ind=0;$ind<count($row);$ind++)
{
$condition="  reserve='Y' and prno>0 and advance=".$row[$ind][0];
$pr=$objPg->rowCount($condition);

$condition="  reserve='Y' and po1no>0 and advance=".$row[$ind][0];
$p1=$objPg->rowCount($condition);

$condition="  reserve='Y' and po2no>0 and advance=".$row[$ind][0];
$p2=$objPg->rowCount($condition);

$condition="  reserve='Y' and po3no>0 and advance=".$row[$ind][0];
$p3=$objPg->rowCount($condition);

$condition=" reserve='Y' and po4no>0 and advance=".$row[$ind][0];
$p4=$objPg->rowCount($condition);

?>
<tr>
<td align="center" width="25%" ><font color=blue size=2 face=arial>Already Selected for <?php echo $row[$ind][1];?></td>    
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $pr;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p1;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p2;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p3;?></td>
<td align="center" width="15%" bgcolor=#FFFFCC><font color=blue size=2 face=arial><?php echo $p4;?></td>

</tr>

<?php }?>
<tr>
<td align=right bgcolor=#FFFFCC>Enter New Value</td>   
<td align=center bgcolor=#FFFFCC>
<input type=text size=5 name="Pr" id="Pr"  onfocus="ChangeColor('Pr',1)"  onblur="ChangeColor('Pr',2)" value="0">
</td>
<?php $i++; //Now i=10?>
<td align=center bgcolor=#FFFFCC>
<input type=text size=5 name="P1" id="P1"  onfocus="ChangeColor('P1',1)"  onblur="ChangeColor('P1',2)" value="0">
<font color=red size=3 face=arial>*</font>
</td>
<?php $i++; //Now i=11?>
<td align=center bgcolor=#FFFFCC>
<input type=text size=5 name="P2" id="P2"  onfocus="ChangeColor('P2',1)"  onblur="ChangeColor('P2',2)" value="0">
</td>
<?php $i++; //Now i=12?>
<td align=center bgcolor=#FFFFCC>
<input type=text size=5 name="P3" id="P3"  onfocus="ChangeColor('P3',1)"  onblur="ChangeColor('P3',2)" value="0">
</td>
<?php $i++; //Now i=13?>
<td align=center bgcolor=#FFFFCC>
<input type=text size=5 name="P4" id="P4"  onfocus="ChangeColor('P4',1)"  onblur="ChangeColor('P4',2)" value="0">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
</table>
</td></tr>
<?php $i++; //Now i=14?>
<tr><td align=right bgcolor=#FFFFCC>
</td><td align=left bgcolor=#FFFFCC>
<input type=button value=Proceed  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" >
<input type=button value=Menu  name=back1 onclick=home() onfocus="ChangeFocus('Phaseno')" style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
</td></tr>

</table>
</form>         
</body></html>
