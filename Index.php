<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Parliament Election 2014, Main Menu(NIC ,Nalbari)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php
session_start();
require_once './Class/Class.Frame.php';
require_once './Class/Class.userlog.php';
require_once './Class/Class.pwd.php';
require_once './Class/utility.class.php';

$objUtility=new Utility();

$objF=new Frame();
$objUl=new Userlog();
$objPwd=new Pwd();
$objPwd->setUid("root");
$change=false;

//if($objPwd->EditRecord())
//{
//if($objPwd->getFirst_login()=="Y")    
//$change=true;    //First Time Set Password is required
//}
//else 
//{
//$change=true;    
//}  

$totvalue=$objPwd->rowCount("1=1")+$objUl->rowCount("1=1");

if($totvalue==0) //Both PWD and Userlog is Blank
$change=true;
else
$change=false;    


if($change==false) //Password Exist
{
if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];
else
$ip="-";
$sql="update userlog set Active='N'";
$sql=$sql." where Client_ip='".$ip."'";
//$objUtility->saveTextLog("UserLog",$sql);
$objF->ExecuteQuery($sql);
//$objUtility->saveTextLog("UserLog","Reset preveous  Session");


$objUl->setUid("unknown");
$objUl->setActive("F");
$objUl->setLog_time_in(date('H:i:s'));
$_SESSION['sid']=$objUl->maxSession_id();
$objUl->setSession_id($_SESSION['sid']);
if($objUl->SaveRecord()) 
{
$objUtility->saveTextLog("UserLog","Start Session ID-".$_SESSION['sid']);
$objUtility->saveTextLog("UserLog","Loged at ".date('H:i:s')." From ".$ip);
header('Location:LoginFrame.php');
}
else
echo "Unable to Create Session ID";    
}//if($change==false)
else
header('Location:./Class/ChangeFirstPwd.php');
?>    
   
</body>
</html>
