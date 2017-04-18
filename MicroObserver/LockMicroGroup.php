<html>
<head>
<title>Lock Poling group</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="Randmenu.php?tag=1";
}
</script>
<BODY>
<script language=javascript>
<!--
</script>
<body onload=setMe()>
<?php
session_start();
//require_once '../class/class.lac.php';
require_once '../class/utility.class.php';
//require_once '../class/class.Polinggroup.php';
//require_once '../class/class.psname.php';
require_once '../class/class.final.php';
//require_once '../class/class.training.php';
require_once '../class/class.final.php';
//require_once '../class/class.status.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();

//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: Mainmenu.php?unauth=1');
//End Verify

//$objPs=new Psname();
//$objPg=new Polinggroup();
//$objTrg=new Training();

$objF=new LacFinal();

        
if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if(!is_numeric($code))
$code=0;


$objF->setLac($code);
$objF->setMtype("5");
$objF->setLocked("Y");
$objF->SaveRecord();

header('location:Microselect.php?tag=0');
?>
</body>
</html>
