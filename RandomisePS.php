<html>
<title>Randomise Poling Station</title>
</head>
<script type="text/javascript" src="validation.js"></script>

<script language=javascript>
<!--
function home()
{
window.location="Select4Randomise.php?tag=1";
}
function lock()
{
var name = confirm("Confirm?")
if (name == true)
{    
newform.action="Lock3random.php";
newform.submit();
}
}


function reran()
{
//var data="Lac="+document.getElementById('Lac').value;
//data=data+"&Mcode="+document.getElementById('Mcode').value;
//alert(data);
//document.getElementById('Result').innerHTML="Running";
//MyAjaxFunction("POST","RandomisePs.php?tag=1",data,"Result","HTML");
document.getElementById('redone').disabled=true;
document.getElementById('lc').disabled=true;
newform.action="RandomisePs.php?tag=1";
newform.submit();
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=15 height=15><br>Randomising Polling Group...Please Wait";
}


</script>
<body>

<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.psname.php';
require_once './class/class.lac.php';
require_once './class/class.final.php';
require_once './class/class.polinggroup.php';

$objPsname=new Psname();
$objUtility=new Utility();
$objPg=new Polinggroup();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

if (isset($_GET['tag']))
$tag=$_GET['tag'];
else
$tag=0;    

$Code1=0;
$Code2=0;

if (isset($_POST['Lac']))
$lac=$_POST['Lac'];
else
header('Location:index.php');

$laccode=$lac;

$dor="";
$rcond=" and Reporting_tag in(";
$gcond=" and advance in(";
$boxname="Day".$laccode."_0";

if($tag==0) //Entry from Preveous Selection Form
{
if(isset($_POST[$boxname]))
{    
$Code1=1;
$dor=$dor." ".$_POST[$boxname];
if(strlen($_POST[$boxname])>0)
{
$rcond=$rcond."0,";
$gcond=$gcond."0,";
}
}
else
$Code1=0;    

$boxname="Day".$laccode."_1";
if(isset($_POST[$boxname]))
{
$Code2=1;
$dor=$dor." ".$_POST[$boxname];
if(strlen($_POST[$boxname])>0)
{
$rcond=$rcond."1,";
$gcond=$gcond."1,";
}
}
else
$Code2=0; 
$_SESSION['dor']=$dor;
} //$tag==0

if($tag==1) //Entry from Self
{
if(isset($_POST['Mcode']))    
$mcode=$_POST['Mcode'];
else
$mcode=-1;

if($mcode==0) //Advance Day
{
$rcond=$rcond."0,";
$gcond=$gcond."0,";
$Code1=1;
} //mcode==0
if($mcode==1) //Normal Day
{
$rcond=$rcond."1,";
$gcond=$gcond."1,";
$Code2=1;
}//mcode==1
if($mcode==2) // Both Day
{
$rcond=$rcond."0,1,";
$gcond=$gcond."0,1,";
$Code1=1;
$Code2=1;
}//mcode==2
if(isset($_SESSION['dor']))
$dor=$_SESSION['dor'];
}//$tag==1




$rcond=$rcond."10)";
$gcond=$gcond."10)";

if($Code1==1 && $Code2==1)
$mcode=2;
if($Code1==1 && $Code2==0)
$mcode=0;
if($Code2==1 && $Code1==0)
$mcode=1;

//echo $Code1."=".$Code2;


if($Code1==0 && $Code2==0)
{
$_SESSION['msg']="Select Reporting Date";
header('Location:Select4Randomise.php?tag=1');
}



$t2= date('H:i:s'); //set initial time
$tt="";
$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("2");
//echo "lock".$_POST['lockme'];


$objF->setTag("0"); //Already Randomised for Day Advance
if($objF->EditRecord())
$Code1=0;

$objF->setTag("1"); //Already Randomised for Normal Day
if($objF->EditRecord())
$Code2=0;


//if ($objF->EditRecord())
//{
//$fin="Final List";
//$lock=true;//
//}
//else
//{
//$lock=false;
//$fin="";
///}


$objLac=new Lac();
$objLac->setCode($lac);
$objLac->editRecord();
$lac=$lac."-".$objLac->getName();

$pscount=$objPsname->rowCount("Lac=".$laccode);

$cond=array();
$cond[0]=" and Forthpoling_required=0 and Reporting_tag=0";    
$cond[1]=" and Forthpoling_required=1 and Reporting_tag=0";    

$cond[2]=" and Forthpoling_required=0 and Reporting_tag=1";    
$cond[3]=" and Forthpoling_required=1 and Reporting_tag=1";    

$condg=array();
$condg[0]=" and Large=0 and Advance=0";    
$condg[1]=" and Large=1 and Advance=0";    

$condg[2]=" and Large=0 and Advance=1";    
$condg[3]=" and Large=1 and Advance=1";  

if($Code1==1) //Randomise for Advance Day
{
$pscond=" Lac=".$laccode.$cond[0];    
$mcond=" Lac=".$laccode.$condg[0];
$objPg->RandomiseGroup($laccode,$mcond,$pscond);

$pscond=" Lac=".$laccode.$cond[1]; 
$mcond=" Lac=".$laccode.$condg[1];
$objPg->RandomiseGroup($laccode,$mcond,$pscond);
}

if($Code2==1) //Randomise for Normal Reporting Day
{
$mcond=" Lac=".$laccode.$condg[2];
$pscond=" Lac=".$laccode.$cond[2];
$objPg->RandomiseGroup($laccode,$mcond,$pscond);

$mcond=" Lac=".$laccode.$condg[3];
$pscond=" Lac=".$laccode.$cond[3];
$objPg->RandomiseGroup($laccode,$mcond,$pscond);
}
$fin="";
//Randomise Table
//$objPsname->RandomisePS($laccode);
?>
<table border=1 align=center cellpadding=4 cellspacing=0 style=border-collapse: collapse; width=90%>
<Thead>
<tr><td colspan=4 align=Center bgcolor=#ccffcc><font face=arial size=4><?php echo $fin;?> Poling Station with Group Code for LAC-<?php echo $lac;?><br>Date of Reporting-<?php echo $dor;?></font></td>
<td bgcolor=#ccffcc>
<input type=button value=Back  name=back1 onclick=home()  style="font-family:arial; font-size: 12px ; background-color:white;color:blue;width:100px">
   
</td>
</tr>
<tr>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
SlNo
</td>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
PS No
</td>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
Poling Station Name
</td>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
Total Voter
</td>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
Group Code
</td>
</tr>

<?php
$objPsname->setCondString(" Lac=".$laccode.$rcond." order by Psno");
$row=$objPsname->getAllRecord();
$rstring="(";
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr>
<td align=center rowheight="35"><font face=arial size=2>
<?php
echo ($ii+1);
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Part_no'];
echo $tvalue;
?>
</td>
<td align=left><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Psname'];
echo $tvalue;
?>
</td>
<td align=center><font face=arial size=2>
<?php
$tvalue=$row[$ii]['Male']+$row[$ii]['Female'];
echo $tvalue;
//eecho "<br>";
//echo $row[$ii]['Rnumber'];
?>
</td>
<td align=center><font face=arial size=2><b>
<?php
$tvalue=$row[$ii]['Rcode'];
echo $tvalue;
$rstring=$rstring."'".$tvalue."',"
?>
    </b></td>
</tr>
<?php
}//for loop
$rstring=$rstring."'0000')";
//START SHOWING RESERVE GROUP

//$objPg->setCondString(" Lac=".$laccode." and RCODE not in(select RCODE from psname)".$gcond." order by rcode");
$objPg->setCondString(" Lac=".$laccode." and Rcode not in".$rstring.$gcond." order by rcode");

$row=$objPg->getAllRecord();

//echo $objPg->returnSql;
//echo "<br>";
//echo count($row);
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr>
<td align=center rowheight="35" bgcolor="grey"><font face=arial size=2>
<?php
echo ($ii+1);
?>
</td>
<td align=center colspan="3" bgcolor="grey"><font face=arial size=2>
    <b>RESERVE</b>
</TD>
<td align=center bgcolor="grey"><font face=arial size=2><b>
<?php
$tvalue=$row[$ii]['Rcode'];
echo $tvalue;
?>
   </b></td>
</tr>
<?php

} //for loop end for reserve

?>
<form name="newform" method="post" action="Lock3Random.php">
<tr><td colspan=4 bgcolor="#ccffcc" align="center">
<input type="hidden" size="2" name="Lac" id="Lac" value="<?php echo $laccode;?>">
<input type="hidden" size="2" name="Mcode" id="Mcode" value="<?php echo $mcode;?>">
<div id="Result">
<input type="button" value="Redo Randomisation" name=redone id="redone" style="font-family:arial; font-size: 12px ;font-weight:bold; background-color:white;color:black;width:160px" onclick="reran()">
</div>
    </td><td align="center" bgcolor="#ccffcc">
<input type="button" value="Lock" name=lc id="lc" style="font-family:arial; font-size: 12px ;font-weight:bold; background-color:red;color:black;width:60px" onclick="lock()">    
</td></tr>
</form>
<?php
        
$tt=$tt."(Query took ";
$t1= date('H:i:s');
$mrow=$objUtility->elapsedTime($t1, $t2);
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Minutes ";
//if ($mrow['s']>0)
$tt= $tt.$mrow['s']." Second";
$tt= $tt.")";
?>
</table>
<?php
echo $objUtility->alert($tt);
?>
</body>
</html>
