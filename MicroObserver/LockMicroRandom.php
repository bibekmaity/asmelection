<html>
<head>
<title>Lock Final Randomisation group</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="../mainmenu.php?tag=1";
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

require_once '../class/class.final.php';
require_once '../class/utility.class.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objF=new LacFinal();

     
if (isset($_POST['Lac']))
$laccode=$_POST['Lac'];
else
$laccode=0;

if (isset($_POST['Mcode']))
$Mcode=$_POST['Mcode'];
else
$Mcode=0;

//echo $laccode."<br>";
//echo $Mcode."<br>";
$Code1=1;
$Code2=1;

//if($Mcode==0)
//$Code1=1;

//if($Mcode==1)
//$Code2=1;

//if($Mcode==2)
//{    
//$Code2=1;   
//$Code1=1;
//}



echo "mcode".$Mcode;
echo "Code1=".$Code1;
echo "Code2=".$Code2;

$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("6");
//echo "lock".$_POST['lockme'];
   
$objF->setLocked ("Y");
if ($Code1==1)
{
$objF->setTag("0");    
if ($objF->SaveRecord())
{
$Code1. $objF->returnSql."<br>";   
//Mark Rest Group as Reserve
$sql="update poling set Selected='R' where Pollcategory=7 and grpno in(select grpno from Microgroup where Advance=0 and Lac=".$laccode." and Reserve='Y')";   
$objF->ExecuteQuery($sql);
}    
//echo $sql;
}//$Code1==1

//echo $objF->returnSql."<br>";
if ($Code2==1)
{
$objF->setTag("1");    
if ($objF->SaveRecord())
{
$Code2. $objF->returnSql."<br>";     
$sql="update poling set Selected='R' where Pollcategory=7 and grpno in(select grpno from Microgroup where Advance=1 and Lac=".$laccode." and Reserve='Y')";   
$objF->ExecuteQuery($sql);
}  //$objF->Saverecord
}//$Code2==1
//echo $sql."<br>";


//if ($objF->SaveRecord())
header( 'Location: SelectPs4Micro.php?tag=0');    
//else
echo "<a href=Select4Randomise.php>Failed to Lock</a>";
?>
</body>
</html>
