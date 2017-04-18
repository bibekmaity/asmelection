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

$objF=new LacFinal();
     
if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if (!is_numeric($code))
$code=0;
    
$objF->setLac($code);
$objF->setMtype("4");
$objF->setLocked("Y");

if ($objF->SaveRecord())
{
$sql="update cu,evmgroup set cu.used='R' where cu.cu_code=evmgroup.cu and evmgroup.reserve='Y'";
$objF->ExecuteQuery($sql);
$sql="update bu,evmgroup set bu.used='R' where bu.bu_code=evmgroup.bu and evmgroup.reserve='Y'";
$objF->ExecuteQuery($sql);
echo $objUtility->AlertNRedirect("EVM Pair Locked","Select4RandomiseEVM.php?tag=0");
}
else
echo $objUtility->AlertNRedirect("","Mainmenu.php?tag=0");

?>
</body>
</html>
