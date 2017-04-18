<body>
<?//php include("connection.php"); ?>
<?php
session_start();
date_default_timezone_set("Asia/kolkata");

require_once './class/utility.class.php';
require_once './class/class.Frame.php';


$objUtility=new Utility();
if(isset($_GET['id']))
$id=$_GET['id'];
else 
$id="0";    
$objF=new Frame();    
$sid=$objF->getSession_id();
if($id=="R")
$sql="update Userlog set Right_frame=0 where Session_id=".$sid;
if($id=="L")
$sql="update Userlog set Left_frame=0 where Session_id=".$sid;
if($id=="M")
$sql="update Userlog set Middle_frame=0 where Session_id=".$sid;


if($objF->ExecuteQuery($sql))
{
//$objUtility->saveTextLog("UserLog","(Session ID-".$sid.")Frame Unloaded Forcefully at ".date('H:i:s'));
if(isset($_SESSION['uid']))
unset($_SESSION['uid']);
if(isset($_SESSION['sid']))
unset($_SESSION['sid']);
}
$ii=0;

?>

</body>
</html>
