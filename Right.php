
<body>

    
<span style="background-color: #66CCCC">
<font face=arial size=2><b>
Current Login</b><br>
</span>
</font>
<?php
session_start();

if(isset($_SESSION['uid']))
$uid=$_SESSION['uid'];
else
$uid="";    

require_once './class/class.Frame.php';
require_once './class/class.userlog.php';

$objF=new Frame();
$objU=new Userlog();

if($objU->SessionActive()==false)
header('Refresh: 20;url=right.php');
    

//if($_SESSION['error']==true)
//header( 'Location: Error.php');



require_once './class/utility.class.php';
require_once './class/class.userlog.php';
require_once './class/class.pwd.php';


$objF=new Frame();    
$sid=$objF->getSession_id();
$sql="update Userlog set Right_frame=1 where Session_id=".$sid;
$objF->ExecuteQuery($sql);

//$objUtility->saveSqlLog("right", $sql);
//$objUtility=new Utility();
$objPwd=new Pwd();

$objUserlog=new Userlog();
//$objUserlog->setCondstring("Log_date='".."' order by Uid");
if(isset($_SESSION['uid']))
$me=$_SESSION['uid'];
else 
$me="-";  

if(isset($_SESSION['sid']))
$sid=$_SESSION['sid'];
else 
$sid=0;


if (isset($_SESSION['username']))
$mename=$_SESSION['username'];
else
$mename="";    

$mydate=date('Y-m-d');
$status="";
$objPwd->setCondString("Uid in (Select Uid from Userlog where Uid<>'".$me."' and Log_date='".$mydate."')");
$row=$objPwd->getAllRecord();
//echo $objPwd->returnSql;
if($me!="-")
{
if($objUserlog->isActive($me))
$bgcol="#CC33FF";
else
$bgcol="#CCCCFF"; 
?>
<font face=arial size=1 color=<?php echo $bgcol;?>><b>
<?php
echo $mename."</b></font><br>"; //Login User from this Computer
}
for($ii=0;$ii<count($row);$ii++)
{
$tvalue=$row[$ii]['Fullname'];
if($objUserlog->isActive($row[$ii]['Uid']))
{    
$status="ACTIVE" ;
$bgcol="#CC33FF";
}
else
{
$status="LOG OUT" ;   
$bgcol="#CCCCFF";
}
if ($status=="ACTIVE")
{
?>
<b>
<?php }?>
<font face=arial size=1 color=<?php echo $bgcol;?>>
<?php
echo $tvalue."</font><br>";
}

?>

</html>