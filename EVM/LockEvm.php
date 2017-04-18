<html>
<head>
<title>Lock EVM group</title>
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

     
if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if (!is_numeric($code))
$code=0;
    
$objF->setLac($code);
$objF->setMtype("3");
$objF->setLocked("Y");
if ($objF->SaveRecord())
header( 'Location: CreateEVMGroup.php?tag=0');    
else
echo "<a href=CreateEVMGroup.php?tag=0>Failed to Lock</a>";
?>
</body>
</html>
