<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.pwd.php';
require_once './class/class.sentence.php';

$objC=new Sentence();

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();

//Start Verify
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify


$objPwd=new Pwd();
$Err="<font face=arial size=1 color=blue>";

if (isset($_POST['Uid']))
$a_Uid=$_POST['Uid'];
else
header('loation:Changepwd.php');
$mvalue[0]=$a_Uid;

if ($objUtility->validate($a_Uid,20)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($a_Uid)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-1";
}

if (strlen($a_Uid)==0)
$myTag++;
}
else
$myTag++;
$b_Pwd=$_POST['Pwd'];
$oldPwd=$b_Pwd;
$mvalue[1]=$b_Pwd;
if ($objUtility->validate($b_Pwd,20)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($b_Pwd)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-2";
}

if (strlen($b_Pwd)==0)
$myTag++;
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objPwd->setUid($_SESSION['uid']);
$objPwd->EditRecord();
$b_Pwd=$objC->Encrypt($b_Pwd);
if ($objPwd->getPwd()==$b_Pwd || strlen($oldPwd)<4)
{
$_SESSION['msg']="Use Different Password than Old One(At Least 4 Character long)";
header( 'Location: ChangePWD.php?tag=1');
}
else 
{
$objPwd->setPwd($b_Pwd);
$objPwd->setFirst_login("N");
//$objPwd->setFirstlogin("N");
if ($objPwd->UpdateRecord())
//$_SESSION['pwd']= $b_Pwd; //set new password
{
//$_SESSION['msg']="Password Changed Succesfully, Relogin with New Password";   
$_SESSION['msg']="";
echo $objUtility->alert($objPwd->returnSql);
$msg1="Password Changed Succesfully, Relogin with New Password";
$objUtility->saveTextLog("UserLog","Password Changed ".date('H:i:s'));
echo $objUtility->AlertNRedirect($msg1,"indexPage.php?tag=1");
}
else 
{
$_SESSION['msg']="";
$msg1="Failed to Change Password(Use Different)";
echo $objUtility->AlertNRedirect($msg1,"ChangePwd.php?tag=0");
}
//header( 'Location: indexPage.php?tag=1');
}
} //mytag=0


?>
<a href=Changepwd.php?tag=1>Back</a>
</body>
</html>
