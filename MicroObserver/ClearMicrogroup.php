<html>
<head>
<title>Clear Micro Group</title>
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
require_once '../class/class.poling.php';
require_once '../class/utility.class.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: Mainmenu.php?unauth=1');
//End Verify

if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if(!is_numeric($code))
$code=0;

$objPoling=new Poling();


$sql="update poling set selected='Y',grpno=0 where pollcategory=7 and grpno in";
$sql=$sql." (select grpno from Microgroup where lac=".$code.")";
if($objPoling->ExecuteQuery($sql))
{
$sql="Delete from Microgroup  ";
$sql=$sql." where lac=".$code;
$objPoling->ExecuteQuery($sql);
}


echo "Effected ".mysql_affected_rows();

$sql=" delete from final where mtype=5 and lac=".$code;
$objPoling->ExecuteQuery($sql);

header('location:MicroSelect.php?tag=0');
?>
</form>
<a href="cleargroup.php?tag=0">Back</a>
</body>
</html>
