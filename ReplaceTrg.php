<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.polinggroup.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objPoling=new Poling();

$field=array();
$field[1]="Prno";
$field[2]="Po1no";
$field[3]="Po2no";
$field[4]="Po3no";
$field[5]="Po4no";

$dfield=array();
$dfield[1]="dcode";
$dfield[2]="dcode1";
$dfield[3]="dcode2";
$dfield[4]="dcode3";
$dfield[5]="dcode4";

$_SESSION['newid']=0;

if (isset($_POST['Slno'])) //If HTML Field is Availbale
{
$a_Slno=$_POST['Slno'];
}
else //Post Data Not Available
$a_Slno="0";

if (isset($_POST['Newslno'])) //If HTML Field is Availbale
{
$b_Slno=$_POST['Newslno'];
}
else //Post Data Not Available
$b_Slno="0";

if(isset($_POST['Res']))
$res=$_POST['Res'];
else 
$res="";    

$objPoling->setSlno($a_Slno);
if($objPoling->EditRecord())
{
$rmk=$objPoling->getRemarks();
if(strlen($rmk)>1 )
$rmk=$rmk." Exempted by ".$_SESSION['username']." on ".date('d/m/Y')."(Reason ".$res.")";
else
$rmk="Exempted by ".$_SESSION['username']." on ".date('d/m/Y')."(Reason ".$res.")";

$sql="update Poling_training set Poling_id=".$b_Slno." where Phaseno=1 and Poling_id=".$a_Slno;
if($objPoling->ExecuteQuery($sql))
{
$sql="update Poling set Deleted='Y',Remarks='".$rmk."' where Slno=".$a_Slno;
$objPoling->ExecuteQuery($sql);    
}    
}  //editrecotd 


$_SESSION['newid']=$b_Slno;    
header( 'Location: ExemptfromTrg.php?tag=1&res=1'); 
?>

</body>
<a href="randmenu.php">menu</a>
</html>
