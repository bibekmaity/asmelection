<html>
<head>
<title>Clear Group</title>
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
require_once './class/class.poling.php';
require_once './class/utility.class.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if(!is_numeric($code))
$code=0;

$objLac=new Lac();
if($objLac->groupStatus($code)>=4)
$code=0;

$objPoling=new Poling();

$sql="update polinggroup set prno=0,po1no=0,po2no=0,po3no=0,po4no=0,dcode=0,dcode1=0,dcode2=0,dcode3=0,dcode4=0,Reserve='N'";
$sql=$sql." where lac=".$code;
$objPoling->ExecuteQuery($sql);

$sql="update poling set selected='Y',grpno=0 where pollcategory in(1,2,3,4,5) and grpno in";
$sql=$sql." (select grpno from polinggroup where lac=".$code.")";
$objPoling->ExecuteQuery($sql);
echo "Effected ".mysql_affected_rows();

$sql=" delete from final where mtype=1 and lac=".$code;
$objPoling->ExecuteQuery($sql);

header('location:SelectPoling.php?tag=0');
?>
</form>
<a href="cleargroup.php?tag=0">Back</a>
</body>
</html>
