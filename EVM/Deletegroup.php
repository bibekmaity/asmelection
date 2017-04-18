<html>
<head><title>Entry Form</title></head>
<BODY>
<?php
session_start();
require_once '../class/class.Poling.php';
require_once '../class/class.Training.php';
require_once '../class/utility.class.php';

header("Content-Type: text/html; charset=utf-8");

$objUtility=new Utility();
$objTrg=new Training();
$mvalue=array();

$roll=$objUtility->VerifyRoll();
if ($roll==-1 || $roll>1 )
header( 'Location: index.php');

if (isset($_GET['phase']))
$phase=$_GET['phase'];
else
$phase=0;

$mvalue[0]=$phase;

if (isset($_GET['group']))
$gr=$_GET['group'];
else
$gr=0;

$objTrg->setPhaseno($phase);
$objTrg->setGroupno($gr);
//unset($_SESSION['mvalue']);

echo "delete from poling_training where phaseno=".$phase." and groupno=".$gr;

if ($objTrg->ExecuteQuery("delete from poling_training where phaseno=".$phase." and groupno=".$gr))
{
$objTrg->DeleteRecord();
}
$_SESSION['phase']=$mvalue[0];
echo "<br>".$objTrg->returnSql;

if($phase==4)
header( 'Location: Form_Ctraining.php?tag=1');

if($phase==5)
{    
$objTrg->ExecuteQuery("update countinggroup set TRGGROUP=0 where Trggroup=".$gr);
header( 'Location: Form_CGrouptraining.php?tag=1');
}
?>
<a href=Form_training.php?tag=1>Back</a>
</body></html>
