<?php
include("EVMMenuhead.html");
?>
<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function load(i)
{
document.getElementById('lac').value=i;
}



function setMe()
{
myform.lac.focus();
}


function validate()
{
var b_index=parseInt(document.getElementById('lac').value);

if (b_index>0)
{
myform.Save.disabled=true;
//myform.setAttribute("target","_self");//Open in Self
//myform.setAttribute("target","_blank");//Open in New Window
myform.action="RandomiseEVM.php";
myform.submit();
document.getElementById('Result').innerHTML="<image src=../image/Star.gif width=50 height=50><br><b><font size=4 face=arial>Assigning PS Number to EVM group...Please Wait </font></b>";
}
else
alert('Select LAC');
}


function home()
{
//window.location="evmmenu.php?tag=1";
}



//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.final.php';
require_once './class/class.evmgroup.php';

    
$objUtility=new Utility();
$objEvm=new Evmgroup();
//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$objF=new Lacfinal();
$objPsname=new Psname();

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
$mvalue[0]="0";//Lac
$mvalue[1]="0";//Psno
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
// Call $objPsname->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac
// Call $objPsname->MaxPsno() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Psno
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

$objLac=new Lac();
//Start of FormDesign
?>
<form name=myform action=""  method=POST >
 <div align="center" id="Result">
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=90%>

    <tr><td colspan="7" align="center">
  <font face="arial" size="2">Select LAC for EVM Group Randomisation     

<input type=hidden name="lac" id=lac size=5  value=0 readonly>
     
        </td></tr>
<tr>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">LAC Code
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">LAC Name
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Total Group
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">Select
</td>
<td align=center bgcolor=#CCFFCC><font size=2 face=arial color=blue>
<font face="arial" size="2">(Click to Display)
</td>
</tr>
<?php
$rowcount=0;
$objLac->setCondString(" code in(select lac from final where mtype=3)" );
$row=$objLac->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$stat="";
$rowcount++;
$cond="  lac=".$row[$ii]['Code'];
$c2=$objEvm->rowCount($cond);

$objF->setLac($row[$ii]['Code']);
$objF->setMtype("4"); //3 For EVM Group
$lock=false;
$dis2=" ";
$stat=" ";
if ($objF->EditRecord())
{  
$lock=true;
$dis2=" disabled";
$stat="<font face=arial size=2 color=red>PS Allocation Locked";
}

?>
<tr>
<?php  $Code="Code".$rowcount; ?>
<td align=center><font face="arial" size="2">
<?php echo $row[$ii]['Code'];?>
</td>
<?php  $Name="Name".$rowcount; ?>
<td align=left><font face="arial" size="2">
<?php echo $row[$ii]['Name'];?>
</td>
<td align=center><font face="arial" size="2"><?php echo $c2;?></td>
<?php $Res="Res".$rowcount; ?>
<?php  $Clr="Clr".$rowcount; ?>
<td align=center><font face="arial" size="2">
<input type="radio" name="Sel"  onclick="load(<?php echo $row[$ii]['Code'];?>)" <?php echo $dis2;?>>
 </td>
<td align=center>&nbsp;
<?php if ($lock==true) {?>
<image src="../image/printer.png" width="15" height="20" alt="Click Here to View Detail in PDF">
<a href="Evm_PsPDF.php?code=<?php echo $row[$ii]['Code'];?>" target="_blank">
<?php } else {?>    
<a href="ShowEVMGroup.php?code=<?php echo $row[$ii]['Code'];?>">
<?php 
}
echo $stat;
?></a>
</td>
</tr>

<?php
} //while
$_SESSION['rowcount']=$rowcount;
?>

<tr><td align=right bgcolor=#FFFFCC>
</td><td align=left bgcolor=#FFFFCC colspan="6">
<input type=button value=Process  name=Save onclick="validate()">
</td></tr>
</table>
</div>     
</form>

     



</body>

</html>
