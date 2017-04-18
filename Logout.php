<body>
<?//php include("connection.php"); ?>
<?php
session_start();
date_default_timezone_set("Asia/kolkata");

require_once './class/utility.class.php';
require_once './class/class.userlog.php';

require_once './class/class.Frame.php';
$objUtility=new Utility();
$objF=new Frame();

if($objUtility->MyIP()==true)
$objF->DelUtility();


$objUL=new Userlog();
$sid=$objUL->getSession_id();
$sql="update userlog set Active='N',Log_time_out='".date('H:i:s')."' where Session_id=".$sid;

if($objUL->ExecuteQuery($sql))
{
$objUtility->saveTextLog("UserLog",$sql);
$objUtility->saveTextLog("UserLog","Logout at ".date('H:i:s'));
$objUtility->saveTextLog("UserLog","End Session ID- ".$sid."\n");
}


//$line=$sql."\n".date('H:i:s');
if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];  
else
$ip="NA";

if(isset($_SESSION['username']))
$user= $_SESSION['username'];
else
$user="";   

if(isset($_SESSION['uid']))
unset($_SESSION['uid']);

if(isset($_SESSION['sid']))
unset($_SESSION['sid']);

if(isset($_SESSION['roll']))
unset($_SESSION['roll']);

?>
</body>
</html>
