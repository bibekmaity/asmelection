<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.pwd.php';
require_once './class/class.roll.php';
require_once './class/class.sentence.php';


$objSen=new Sentence();

$sql="";
$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objPwd=new Pwd();
$Err="<font face=arial size=1 color=blue>";

//Start Validation //Fullname

if (isset($_POST['Fullname'])) //If HTML Field is Availbale
{
$a_Fullname=$_POST['Fullname'];
$a_Fullname=$objSen->SentenceCase($a_Fullname);
$mvalue[0]=$a_Fullname;
if ($objUtility->validate($a_Fullname,50)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($a_Fullname)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-1";
}

if (strlen($a_Fullname)==0)
{
$a_Fullname="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$a_Fullname="NULL";


//Start Validation //Uid

if (isset($_POST['Uid'])) //If HTML Field is Availbale
{
$b_Uid=$_POST['Uid'];
$mvalue[1]=$b_Uid;
if ($objUtility->validate($b_Uid)==true && strlen($b_Uid)<=20)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Uid)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Uid)==0)
$myTag++;
}
else
$myTag++;
}
else //Post Data Not Available
$b_Uid="NULL";


//Start Validation //Pwd

if (isset($_POST['Pwd'])) //If HTML Field is Availbale
{
$c_Pwd=$_POST['Pwd'];
$mvalue[2]=$c_Pwd;
if ($objUtility->validate($c_Pwd)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($c_Pwd)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-3";
}

if (strlen($c_Pwd)==0 || strlen($c_Pwd)<4 || strlen($c_Pwd)>20)
$myTag++;
}
else
$myTag++;
}
else //Post Data Not Available
$c_Pwd="NULL";


//Start Validation //Roll

if (isset($_POST['Roll'])) //If HTML Field is Availbale
{
$d_Roll=$_POST['Roll'];
$mvalue[3]=$d_Roll;
if (!is_numeric($d_Roll))
$myTag++;
}
else //Post Data Not Available
$d_Roll="NULL";


//Start Validation //Active

$e_Active=0;
if (isset($_POST['Active']))
$e_Active=1;
$mvalue[4]=$e_Active;


$col=0;
$mmode="";
if ($myTag==0)  //Every Vlidation OK
{
$objPwd->setUid($b_Uid);
$objPwd->setFullname($a_Fullname);
$objPwd->setRoll($d_Roll);
$objPwd->setActive($e_Active);
$objPwd->setFirst_login("Y");
if ($_SESSION['update']==0)
{
if ($objPwd->Available()==true)
{
$mmode="User ID already Exist"; 
$result=false;
}
else
{    
$c_Pwd=$objSen->Encrypt($c_Pwd);    
$objPwd->setPwd($c_Pwd);    
$result=$objPwd->SaveRecord();
$mmode="User Created Succesfully";
$sql=$objPwd->returnSql;
$col=1;
} //$objPwd->Available()==true
} //SESSION['update']==0
else //update
{
if(isset($_POST['ResP']))
{
$c_Pwd=$objSen->Encrypt($b_Uid);  
$objPwd->setPwd($c_Pwd);  //Reset to user ID  
$objPwd->setFirst_login("Y");
} //isset($_POST['ResP'
$result=$objPwd->UpdateRecord();
//echo $objPwd->returnSql;
$col=$objPwd->colUpdated;
if ($col>0)
$mmode="Updated User";
//else
//$mmode="Nothing to Update";
$sql=$objPwd->returnSql;
}
$_SESSION['msg']=$mmode;
if (!$result)
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(See Error Log File)";
$objUtility->saveSqlLog("Error",$sql);
//$mmode="Update Error";
}
else
{
//Clear the Required Field back to Entry Form
// Call MaxFullname() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Fullname
// Call MaxUid() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Uid
// Call MaxPwd() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Pwd
// Call MaxRoll() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Roll
// Call MaxActive() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="";//Active
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Pwd",$sql);
$objUtility->Backup2Access("", $sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} //mytag=0
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
//header( 'Location: Form_pwd.php?tag=1');
$page="Form_pwd.php";
echo $objUtility->AlertNRedirect($mmode, $page);
?>

</body>
</html>
