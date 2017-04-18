<?php
session_start();

require_once './class/class.pwd.php';
require_once './class/class.sentence.php';
require_once './class/class.userlog.php';

require_once './class/utility.class.php';

require_once './class/class.copy.php';




$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();

if(isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;    


$objUtility=new Utility();

$objC=new Sentence();

$objUl=new Userlog();

//$_SESSION['msg']="";
//if (isset($_GET['tag']))
//$_tag=$_GET['tag'];
//else
$_tag=0;

$msg="";
$mytag=0;
$oldPwd="";
if ($_tag==0)
{
if(isset($_POST['Uid']))
$a_Uid=$_POST['Uid'];
else
$a_Uid="x";
if(isset($_POST['Pwd']))
{    
$b_Pwd=$_POST['Pwd'];
$oldPwd=$b_Pwd;
}
else
$b_Pwd="x";

if ($objUtility->validate($a_Uid)==false || $objUtility->validate($b_Pwd)==false)
{
$mytag++; //Server Validation Fails
$msg=$msg." Validation Fails";
}

//if($objUl->isActiveUser($a_Uid,8))
if($objUl->isActive($a_Uid))        
{
$mytag++;    
$msg=$msg." User Already Logged in";
}
$b_Pwd=$objC->Encrypt($b_Pwd);
}
else
{
$a_Uid=$_SESSION['uid'];
$b_Pwd=$_SESSION['pwd'];  
}   

//check if User is Already Login
//

$objPwd=new Pwd();
$objPwd->setUid($a_Uid);
//paste here
if($objPwd->EditRecord() && $mytag==0 ) //User Available
{   
if ($b_Pwd==$objPwd->getPwd() && $objPwd->getActive()==0) //Inactive User
{
$msg=" User Locked by Administrator";   
$mytag++;  
}


$first=$objPwd->getFirst_login();   
if ($b_Pwd==$objPwd->getPwd() && $objPwd->getActive()==1)
{
$_SESSION['username']=$objPwd->getFullname();   
$_SESSION['roll']=$objPwd->getRoll();
$_SESSION['uid']=$a_Uid;
$_SESSION['pwd']=$b_Pwd;
} //$b_Pwd==$objPwd->getPwd()
else //$b_Pwd==$objPwd->getPwd()
{
if($mytag==0)
{
$mytag++;    
$msg=" Invalid User or Password";
}
} //Bpwd==$objPwd->getPwd()
} //editrecord
else 
{
$mytag++;    
$msg=$msg." Invalid User"; 
}
//end here

if($mtype==0)
echo $msg;
if($mtype==1)
echo $mytag;


if($mtype==2)//check frame existence
{
$objCp=new CopyF();
if($objCp->AllFrameExist())
{  
?>
<input type=button value=Login  name=Save id="Save" onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:#FF9999;color:black;width:80px" >
<?php
}
else
{
?>
<input type=button value=Login  name=Save id="Save" onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:#FF9999;color:black;width:80px" disabled>
<?php
echo "<font size=2 face=arial color=red>&nbsp;Frame Error(Close and Reload Page)";
}
} //$mtype==2





?>

