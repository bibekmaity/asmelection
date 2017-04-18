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
$objPoling->setSlno($b_Slno);

if($objPoling->EditRecord())
{
$dcode=$objPoling->getDepcode();   
$rmk1= $objPoling->getRemarks();   
if(strlen($rmk1)==0)
$rmk1=" ";
}

$objPoling->setSlno($a_Slno);
if($objPoling->EditRecord())
{
$grp=$objPoling->getGrpno();
$rmk=$objPoling->getRemarks();
if (strlen($rmk)>0)
$rmk=$rmk." (Replaced with ID ".$b_Slno." on ".date('d/m/Y').", Reason-".$res;    
$cat=$objPoling->getPollcategory();
$sql="update poling set selected='N', deleted='Y',grpno=0,remarks='".$rmk."' where slno=".$a_Slno;
echo $sql."<br>";
if ($objPoling->ExecuteQuery($sql)) //updted exempted person
{
$rmk=$rmk1."(Assigned Duty on ".date('d/m/y')." in place of Id-".$a_Slno;    
$sql="update poling set selected='Y',grpno=".$grp.",remarks='".$rmk."' where slno=".$b_Slno;
echo $sql."<br>";
if ($objPoling->ExecuteQuery($sql)) //updated replace person
{
//update group table
$sql="update polinggroup set ".$field[$cat]."=".$b_Slno.",".$dfield[$cat]."=".$dcode." where Grpno=".$grp;    
if($objPoling->ExecuteQuery($sql))
{
$_SESSION['msg']=1;
$sql="update poling_training set Poling_id=".$b_Slno." where Poling_id=".$a_Slno;    
$objPoling->ExecuteQuery($sql);
}
else
$_SESSION['msg']=0;   
echo $sql."<br>";
}    
}  //first if   

}  //editrecotd 
if($_SESSION['msg']==0)
header( 'Location: Exemptfromduty.php?tag=1&res=0');
else
{
$_SESSION['newid']=$b_Slno;    
header( 'Location: Exemptfromduty.php?tag=1&res=1'); 
}
?>

</body>
<a href="randmenu.php">menu</a>
</html>
