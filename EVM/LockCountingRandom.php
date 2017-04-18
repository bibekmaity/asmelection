<html>
<head>
<title>Lock Final Randomisation counting group</title>
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
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objF=new LacFinal();

     
if (isset($_POST['Lac']))
$laccode=$_POST['Lac'];
else
$laccode=0;



$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("8");
$objF->setTag("1");
$objF->setLocked("Y");
//echo "lock".$_POST['lockme'];
     
$objF->SaveRecord();
 
header( 'Location: SelectLac.php?tag=0');    

?>
</body>
</html>
