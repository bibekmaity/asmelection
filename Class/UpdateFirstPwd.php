<body>

<?php
session_start();
require_once 'utility.class.php';
require_once 'class.pwd.php';
require_once 'class.sentence.php';

$objSen=new Sentence();

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objPwd=new Pwd();
$Err="<font face=arial size=1 color=blue>";

//Start Validation //Uid
$_Uid="root";
$mvalue[0]=$_Uid;

if (isset($_POST['Pwd'])) //If HTML Field is Availbale
{
$_Pwd=$_POST['Pwd'];
$mvalue[1]=$_Pwd;
if ($objUtility->SimpleValidate($_Pwd)==true && strlen($_Pwd)<=20)
{
//Check for Unicode if required
if ($objUtility->isUnicode($_Pwd)==true)
{
$myTag++;
$Err=$Err." Expect Unicode in Field-2";
}

if (strlen($_Pwd)==0)
$myTag++;
}
else
{
$myTag++;
echo "Pwd Error<br>";
}
}
else //Post Data Not Available
$_Pwd="NULL";


if (isset($_POST['Pwd1'])) //If HTML Field is Availbale
{
$_Pwd1=$_POST['Pwd1'];
}
else {
$_Pwd1="*";   
}
//Start Validation //Fullname

if (isset($_POST['Fullname'])) //If HTML Field is Availbale
{
$_Fullname=$_POST['Fullname'];
$mvalue[2]=$_Fullname;
if ($objUtility->SimpleValidate($_Fullname,50)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($_Fullname)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}


if (strlen($_Fullname)==0)
{
$_Fullname="NULL";
}
}
else
{
$myTag++;
echo "Fullname Error<br>";
}
}
else //Post Data Not Available
$_Fullname="NULL";


$_Fullname="System Manager";

if (isset($_POST['Ip'])) //If HTML Field is Availbale
$_Ip=$_POST['Ip'];
else
$_Ip="NULL";


if ($objUtility->Validate($_Ip,20)==false)
$myTag++;


$mmode="";
if ($myTag>0) //Validation Fails
{
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
$mmode="Validation Error";
}

if ($myTag==0 && $_Pwd1==$_Pwd) //Validation OK
{
//Update Roll Table    
$sql="INSERT INTO roll(Roll,Description) VALUES('0','System Manager'),";
$sql=$sql." ('1','Administrator'),('2','Super User'),('3','General Operator'),('4','Guest')";
$objPwd->ExecuteQuery($sql);    
    
$objPwd->setUid($_Uid);
$_Pwd=$objSen->Encrypt($_Pwd);
$objPwd->setPwd($_Pwd);
$objPwd->setFullname($_Fullname);
$objPwd->setActive(1);
$objPwd->setRoll("0");
$objPwd->setFirst_login("N");
if($objPwd->Available()==true)
$res=$objPwd->UpdateRecord ();
else
$res=$objPwd->SaveRecord ();    
//Copy the Blank File to Active Folder
$BlankFile = "Election.mdb";
if (file_exists($BlankFile))
copy($BlankFile, '../Election.mdb');
$objUtility->Backup2Access("", $objPwd->returnSql);
} //$mytag==0 

if($res)
{
$msql="update pwd set Allowed_ip='".$_Ip."' where Uid='".$_Uid."'";
$objPwd->ExecuteQuery($msql);
$objUtility->Backup2Access("", $msql);
$msg="Please Login with User [root] and Password ".$mvalue[1];
echo $objUtility->AlertNRedirect($msg, "../index.php");
}
else
{
$msg="Failed, try again";
echo $objUtility->AlertNRedirect($msg, "ChangeFirstPwd.php");
}  
//echo "message".$msg;
?>
</body>
</html>
