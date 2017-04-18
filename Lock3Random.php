<html>
<head>
<title>Lock Final Randomisation group</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="Randmenu.php?tag=1";
}
function go()
{
myform.Save1.disabled=true;   
myform.back1.disabled=true;  
myform.action="LockGroup.Php?tag=2";
myform.submit();
}

</script>
<BODY>
<script language=javascript>
<!--
</script>
<body onload=setMe()>
<?php
session_start();

require_once './class/class.final.php';
require_once './class/utility.class.php';
require_once './class/class.psname.php';
$objUtility=new Utility();

//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objPs=new Psname();

$objF=new LacFinal();

     
if (isset($_POST['Lac']))
$laccode=$_POST['Lac'];
else
$laccode=0;

if (isset($_POST['Mcode']))
$Mcode=$_POST['Mcode'];
else
$Mcode=0;


$rstring=$objPs->getRcodeString($laccode);


//echo $laccode."<br>";
//echo $Mcode."<br>";
$Code1=0;
$Code2=0;

if($Mcode==0)
$Code1=1;

if($Mcode==1)
$Code2=1;

if($Mcode==2)
{    
$Code2=1;   
$Code1=1;
}

$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("2");
//echo "lock".$_POST['lockme'];
echo $Code1."=".$Code2;   
$objF->setLocked ("Y");
if ($Code1==1)
{
$objF->setTag("0");    
if ($objF->SaveRecord())
{
//Mark Rest Group as Reserve
$sql="update polinggroup set Reserve='Y' where  Advance=0 and Lac=".$laccode." and RCODE not in ".$rstring;   
echo $sql."<br>";
if($objF->ExecuteQuery($sql))
{    
$sql="update poling set Selected='R' where grpno in(select grpno from polinggroup where Lac=".$laccode." and Reserve='Y')";   
$objF->ExecuteQuery($sql);
//echo $sql."<br>";
}
}    
//echo $sql;
}//$Code1==1
//echo $objF->returnSql."<br>";
if ($Code2==1)
{
$objF->setTag("1");    
if ($objF->SaveRecord())
{
//Mark Rest Group as Reserve
$sql="update polinggroup set Reserve='Y' where Advance=1 and Lac=".$laccode." and RCODE not in ".$rstring;   
echo $sql;
if($objF->ExecuteQuery($sql))
{    
$sql="update poling set Selected='R' where grpno in(select grpno from polinggroup where Lac=".$laccode." and Reserve='Y')";   
$objF->ExecuteQuery($sql);
}
}  //$objF->Saverecord
}//$Code2==1
//echo $sql."<br>";

//if ($objF->SaveRecord())
header( 'Location: Select4Randomise.php?tag=0');    
//else
echo "<a href=Select4Randomise.php>Failed to Lock</a>";
?>
</body>
</html>
