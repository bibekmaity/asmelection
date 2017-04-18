<html>
<head>
<title>Clear Micro PS</title>
</head>
<script language=javascript>
<!--
function home()
{
window.location="SelectDepartment.php?tag=1";
}


</script>
<BODY>
<script language=javascript>
<!--
</script>
<body onload=setMe()>
<?php
session_start();
require_once '../class/class.MicroPs.php';
require_once '../class/utility.class.php';

$objUtility=new Utility();


$objMg=new Microps();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: Mainmenu.php?unauth=1');
//End Verify

if (isset($_POST['Mgrp']))
$code=$_POST['Mgrp'];
else
$code=0;

$mvalue=array();
if(isset($_POST['Lac']))
$mvalue[0]=$_POST['Lac'];
else
$mvalue[0]=0;

$mvalue[1]=$objMg->maxGrpno();

if(!is_numeric($code))
$code=0;



$sql="Delete from Microps where Grpno=".$code;
if ($objMg->ExecuteQuery($sql))
{
$sql="update psname set Micro_group=0 where Micro_group=".$code;
if($objMg->ExecuteQuery($sql));
$_SESSION['msg']="PS Allocation Cleared";
}

$_SESSION['mvalue']=$mvalue;

header('location:MicroStart.php?tag=1');
?>
</form>
<a href="cleargroup.php?tag=0">Back</a>
</body>
</html>
