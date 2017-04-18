<?php
require_once 'MenuHead.html';
?>
<script language=javascript>
<!--

function enu(i)
{
myform.Myoption.value=i;
myform.Save.disabled=false;
if(i==2)
myform.blank.disabled=false;
else
myform.blank.disabled=true;    
}
function validate(i)
{
var i=myform.Myoption.value;
var a=myform.Code.selectedIndex ;
var b=myform.rtag.selectedIndex ;

var f1=parseInt(myform.from1.value);
var f2=parseInt(myform.from.value);

var m1=parseInt(myform.to1.value);
var m2=parseInt(myform.to.value);

if(f2<f1 || m2>m1 || f2>m2)
{    
alert('Invalid Group Combination')
myform.from.value=f1;
myform.to.value=m1;
}
else
{
if (a>0 && b>0)
{
myform.setAttribute("target", "_blank");    

if(i==1)
myform.action="./PDFReport/ViewDecodeRegisterinPDF.php?code="+b;


if(i==2)
myform.action="./PDFReport/ViewDecodeSlipinPDF.php?code="+b;

if(i==3)
myform.action="./PDFReport/ReserveregisterinPDF.php?code="+b;

myform.Save.disabled=true;
myform.submit();
}
else
alert('Invalid Selection');
}
}

function home()
{
window.location="mainmenu.php?tag=1";
}

function redirect(i)
{
myform.setAttribute("target", "_self");       
myform.action="Viewgroup4Decode.php?tag=2";
myform.submit();
}

</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.lac.php';
require_once './class/class.party_calldate.php';

require_once './class/class.Polinggroup.php';
$objPg=new Polinggroup();

$objUtility=new Utility();
$objTp=new Party_calldate();
//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: mainmenu.php?unauth=1');
//End Verify

$objLac=new Lac();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;
$rtag=-1;
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

if(isset($_POST['rtag']))
$rtag=$_POST['rtag'];
else
$rtag=-1;

$start=$objPg->minRcode($lac,$rtag);
$last=$objPg->maxRcode($lac,$rtag);
}



//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width="70%">
<form name=myform   method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>DECODING REGISTER AND SLIP<br></font><font face=arial color=red size=2></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Select LAC</font></td><td align=left bgcolor=#FFFFCC>
<?php 
$objLac->setCondString(" code>0 and code in(select distinct lac from polinggroup) order by code" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Code style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($objLac->groupStatus($row[$ind]['Code'])>4)
{
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

}
?>
</select>
 </td>
</tr>
<tr>
<td align=right bgcolor=#FFFFCC><font color=black size=2 face=arial>Select Reporting Date</font></td><td align=left bgcolor=#FFFFCC>
<?php 
$str=" Code in(select tag from final where Lac=".$lac." and mtype=2)"; //Change the condition for where clause accordingly
$objTp->setCondString($str);
$row=$objTp->getRow();
//echo $objTp->returnSql;
?>
<select name=rtag style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=redirect(2)>
<?php $dval="-1";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode= $row[$ind][0];
$mdetail= $row[$ind][1];
if($mcode==$rtag)
{
?>
<option  selected value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php
}
else
{
?>
<option  value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php
} 
}//for loop
?>
</select>
 </td>
</tr>

<tr>
<td align="center" rowspan=5><font face=arial size=2><input type=checkbox name=mpdf id=mpdf checked=checked>In PDF</td>    
<td align="left"><font size=2 face=arial>
From  Code
<input type="hidden" name="from1" size="3" value="<?php echo $start;?>">
<input type="text" name="from" size="3" value="<?php echo $start;?>">
To
<input type="hidden" name="to1" size="3" value="<?php echo $last;?>">
<input type="text" name="to" size="3" value="<?php echo $last;?>">
</td></tr>        
<tr><td align="LEFT" ><font size=2 face=arial>
<input type="radio" name="opt" onclick="enu(1)">
View Decoding Register
    </td></tr>
<tr><td align="LEFT" ><font size=2 face=arial>
<input type="radio" name="opt" onclick="enu(2)">
View Decoding Slip
    </td></tr>
<tr><td align="LEFT" ><font size=2 face=arial>
<input type="radio" name="opt" onclick="enu(3)">
View Reserve Group Register
    </td></tr>
<tr><td align="left">
<input type="hidden" name="Myoption" >        
<input type=button value="View Report"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:#99CCCC;color:blue;width:150px" disabled>
   
</td></tr>
</table>
</form>
<?php
include("footer.htm");
?>   
</body>
</html>
