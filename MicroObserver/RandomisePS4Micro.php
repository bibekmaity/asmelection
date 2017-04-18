<html>
<title>Randomise Poling Station for  Micro Observer</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="SelectPS4Micro.php?tag=1";
}
function lock()
{
var name = confirm("Confirm?")
if (name == true)
{    
newform.action="LockMicroRandom.php";
newform.submit();
}
}
</script>
<body>


<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.final.php';
require_once '../class/class.Microgroup.php';
require_once '../class/class.Microps.php';
require_once '../class/class.Poling.php';

$objMps=new Microps();
$objPsname=new Psname();
$objUtility=new Utility();
$objMg=new Microgroup();
$objPol=new Poling();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


if (isset($_POST['Lac']))
$lac=$_POST['Lac'];
else
header('Location:index.php');

$laccode=$lac;
$dor="";
$rcond=" and Advance in(";
$boxname="Day".$laccode."_0";

if(isset($_POST[$boxname]))
{    
$Code1=1;
$dor=$dor." ".$_POST[$boxname];
if(strlen($_POST[$boxname])>0)
$rcond=$rcond."0,";
}
else
$Code1=0;    

$boxname="Day".$laccode."_1";
if(isset($_POST[$boxname]))
{
$Code2=1;
$dor=$dor." ".$_POST[$boxname];
if(strlen($_POST[$boxname])>0)
$rcond=$rcond."1,";
}
else
$Code2=0; 

$rcond=$rcond."10)";

if($Code1==1 && $Code2==1)
$mcode=2;

if($Code1==1 && $Code2==0)
$mcode=0;

if($Code2==1 && $Code1==0)
$mcode=1;


//echo $Code1."=".$Code2;

//if($Code1==0 && $Code2==0)
//{
//$_SESSION['msg']="Select Reporting Date";
//header('Location:SelectPs4Micro.php?tag=1');
//}

$t2= date('H:i:s'); //set initial time
$tt="";
$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("6");
//echo "lock".$_POST['lockme'];


$objF->setTag("0"); //Already Randomised for Day Advance
if($objF->EditRecord())
{    
$Code1=0;
//$sql="update microgroup set Micropsno=0 where Advance=0 and Lac=".$laccode;
//$objF->ExecuteQuery($sql);
}

$objF->setTag("1"); //Already Randomised for Normal Day
if($objF->EditRecord())
{    
$Code2=0;
//$sql="update microgroup set Micropsno=0 where Advance=1 and Lac=".$laccode;
//$objF->ExecuteQuery($sql);
}

//if ($objF->EditRecord())
//{
//$fin="Final List";
//$lock=true;
//}
//else
//{
//$lock=false;
$fin="";
//}


$objLac=new Lac();
$objLac->setCode($lac);
$objLac->editRecord();
$lac=$lac."-".$objLac->getName();

$pscount=$objMps->rowCount("Lac=".$laccode);

$cond=array();

$cond[0]=" and  Advance=0";    
$cond[1]=" and  Advance=1";    

//HARD CODE
$Code1=1;
$Code2=1;
$rcond=" and 1=1 ";

if($Code1==1) //Randomise for Advance Day
{
$pscond=" Lac=".$laccode.$cond[0];    
$mcond=" Lac=".$laccode.$cond[0];
$objMg->RandomiseGroup($laccode,$mcond,$pscond);
}

if($Code2==1) //Randomise for Normal Reporting Day
{
$mcond=" Lac=".$laccode.$cond[1];
$pscond=" Lac=".$laccode.$cond[1];
$objMg->RandomiseGroup($laccode,$mcond,$pscond);
}
//Randomise Table
//$objPsname->RandomisePS($laccode);

?>


<table border=1 align=center cellpadding=4 cellspacing=0 style=border-collapse: collapse; width=90%>
<Thead>
<tr><td colspan=4 align=Center bgcolor=#ccffcc><font face=arial size=4><?php echo $fin;?> Poling Station with Micro Observer for LAC-<?php echo $lac;?></font></td>
<tr>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
SlNo
</td>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
Poling Station No and Names
</td>
<td align=center bgcolor="#FFFF33"><font face=arial size=3>
Micro Id
</td>
<td align=center bgcolor="#FFFF33" colspan="2"><font face=arial size=3>
Name of Micro Observer
</td>
</tr>

<?php

$objMg->setCondString(" Lac=".$laccode.$rcond." order by Reserve,Micropsno");
$row=$objMg->getAllRecord();
//echo $objPsname->returnSql;
//echo $objPsname->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
    
$grp=$row[$ii]['Micropsno'];
$myrow=$objPsname->getMicroPsList($grp);    

//$rspan=count($myrow);
//if($rspan<1)
$rspan=1;
?>
<tr>
<td align=center rowheight="35" rowspan="<?php echo $rspan;?>"><font face=arial size=2>
<?php
echo ($ii+1);
?>
</td><td align=left><font face=arial size=2>
<?php
if($grp>0)
{
for($mm=0;$mm<count($myrow);$mm++)
{
echo $myrow[$mm]['Part_no']." ".$myrow[$mm]['Psname']."<br>";  
} //for loop
}
else
echo "Reserve";
?>
<td align=center rowspan="<?php echo $rspan;?>"><font face=arial size=2>
<?php
echo $row[$ii]['Micro_id'];
?>
</td>
<td align=left rowspan="<?php echo $rspan;?>"><font face=arial size=2><b>
<?php
$objPol->setSlno($row[$ii]['Micro_id']);
if($objPol->EditRecord())
{
$tvalue=$objPol->getName ()."</b>,".$objPol->getDesig ()."<br>";  
echo $tvalue;
$tvalue=$objPol->getDepartment()."<br>Phone-".$objPol->getPhone();  
echo $tvalue;
}
?>
    </b></td>
</tr>
<?php
}
?>
<form name="newform" method="post" action="Lock3Random.php">
<tr><td colspan=3>
<input type="hidden" size="2" name="Lac" value="<?php echo $laccode;?>">
<input type="hidden" size="2" name="Mcode" value="<?php echo $mcode;?>">
<input type=button value=Back  name=back1 onclick=home()  style="font-family:arial; font-size: 12px ; background-color:white;color:blue;width:100px">
    
</td>
    <td align="center">
<input type="button" value="LOCK" name=l style="font-family:arial; font-size: 12px ;font-weight:bold; background-color:red;color:black;width:60px" onclick="lock()">    
</td></tr>
</form>
<?php
$t1= date('H:i:s');        
$tt=$tt.$objUtility->elapsedTimeMsg($t1, $t2);

//$mrow=$objUtility->elapsedTime($t1, $t2);
//if ($mrow['h']>0)
//$tt= $tt.$mrow['h']." Hours ";
//if ($mrow['m']>0)
//$tt= $tt.$mrow['m']." Minutes ";
//if ($mrow['s']>0)
//$tt= $tt.$mrow['s']." Second";
//$tt= $tt.")";

echo $objUtility->alert($tt);

?>
</table>
</body>
</html>
