<?php
require_once 'MiscMenuHead.html';
?>
<script language=javascript>
<!--


function validate()
{

var a=myform.Code.selectedIndex ;

var b=myform.Ps.selectedIndex ;

if (a>0 && b>0)
{
myform.setAttribute("target", "_self");       
myform.action="PsWiseOfficer.php?tag=1";
myform.Save.disabled=true;
myform.submit();
}
else
alert('Invalid Selection');
}


function home()
{
window.location="../mainmenu.php?tag=1";
}

function redirect(i)
{
myform.setAttribute("target", "_self");       
myform.action="PsWiseOfficer.php?tag=2";
myform.submit();
}

</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.lac.php';

require_once '../class/class.Polinggroup.php';
require_once '../class/class.psname.php';
require_once '../class/class.poling.php';

$objPs=new Psname();

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$objLac=new Lac();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>2)
$_tag=0;

if($_tag==0)
{
$lac=0;
$start=0;
$last=0;
$rtag=-1;
}

if ($_tag==2)//Post Back 
{
if(isset($_POST['Code']))
$lac=$_POST['Code'];
else
$lac=0;

if(isset($_POST['Ps']))
$ps=$_POST['Ps'];
else
$ps=0;

}

if ($_tag==1)//Post Back 
{
if(isset($_POST['Code']))
$lac=$_POST['Code'];
else
$lac=0;

if(isset($_POST['Ps']))
$ps=$_POST['Ps'];
else
$ps=0;
}

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=70%>
<form name=myform   method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Poling Station Wise Officer List(After Final Decoding)<br></font><font face=arial color=red size=2></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Select LAC</font></td><td align=left bgcolor=#FFFFCC>
<?php 
$objLac->setCondString(" Code in(select Lac from Final where mtype=2) order by Code" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Code id="Code" style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
//if ($objPg->PresentCategory($row[$ind]['Code'])==0)
if ($lac==$row[$ind]['Code'])
{
?>
<option selected value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];
} //$mvalue

}
?>
</select>
 </td>
</tr>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Select Poling Station</font></td><td align=left bgcolor=#FFFFCC>
<?php 
$cond="(Select Tag from Final where mtype=2 and Lac=".$lac.")";
$str=" Lac=".$lac." and Reporting_tag in ".$cond; //Change the condition for where clause accordingly
$objPs->setCondString($str);
$row=$objPs->getAllRecord();
//echo $objTp->returnSql;
?>
<select name=Ps id="Ps" style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:270px" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode= $row[$ind]['Psno'];
$mdetail= $row[$ind]['Psname'];
$part=$row[$ind]['Part_no'];
if($mcode==$ps)
{
?>
<option  selected value="<?php echo $mcode;?>">[<?php echo $part."] ".$mdetail;?>
<?php
}
else
{
?>
<option  value="<?php echo $mcode;?>">[<?php echo $part."] ".$mdetail;?>
<?php
} 
}//for loop
?>
</select>
 </td>
</tr>
<tr><td>&nbsp;</td><td align="left">
<input type=button value="List Group"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:#99CCCC;color:blue;width:150px" >
</td></tr>
</form>
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Final Group List</td></tr>
<?php
if($_tag==1)
{
$objPs->setLac($lac);
$objPs->setPsno($ps);
if($objPs->EditRecord())
$rcode=$objPs->getRcode ();
else
$rcode=0;   
$grp=$rcode-1000;
$objPol=new Poling();
$objPol->setCondString("Grpno=".$grp." order by Pollcategory");
$row=$objPol->getRow();
//echo $objPol->returnSql;
for($i=0;$i<count($row);$i++)
{
$slno=$row[$i][0];    
?>
<tr><td align="left" colspan="2"><font face="arial" size="2" color="blue">
<?php echo $objPol->PolingDetail4APRBook($slno);  ?>      
        <br></td></tr>       

<?php
}//for Loop
} //$_tag==1


?>
<?php
include("footer.htm");
?>  
</table>
</body>
</html>
