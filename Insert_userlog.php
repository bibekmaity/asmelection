<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.userlog.php';
require_once './class/class.pwd.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objUserlog=new Userlog();
$Err="<font face=arial size=1 color=blue>";

//Start Validation //Uid

if (isset($_POST['Uid'])) //If HTML Field is Availbale
{
$a_Uid=$_POST['Uid'];
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
}
else //Post Data Not Available
$a_Uid="NULL";


//Start Validation //Log_time_in

if (isset($_POST['Log_time_in'])) //If HTML Field is Availbale
{
$c_Log_time_in=$_POST['Log_time_in'];
$mvalue[1]=$c_Log_time_in;
if ($objUtility->validate($c_Log_time_in,15)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($c_Log_time_in)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($c_Log_time_in)==0)
$myTag++;
}
else
$myTag++;
}
else //Post Data Not Available
$c_Log_time_in="NULL";


//Start Validation //Log_time_out

if (isset($_POST['Log_time_out'])) //If HTML Field is Availbale
{
$d_Log_time_out=$_POST['Log_time_out'];
$mvalue[2]=$d_Log_time_out;
if ($objUtility->validate($d_Log_time_out,15)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($d_Log_time_out)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($d_Log_time_out)==0)
$myTag++;
}
else
$myTag++;
}
else //Post Data Not Available
$d_Log_time_out="NULL";


//Start Validation //Client_ip

if (isset($_POST['Client_ip'])) //If HTML Field is Availbale
{
$e_Client_ip=$_POST['Client_ip'];
$mvalue[3]=$e_Client_ip;
if ($objUtility->validate($e_Client_ip,30)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($e_Client_ip)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-4";
}

if (strlen($e_Client_ip)==0)
$myTag++;
}
else
$myTag++;
}
else //Post Data Not Available
$e_Client_ip="NULL";


//Start Validation //Session_id

if (isset($_POST['Session_id'])) //If HTML Field is Availbale
{
$f_Session_id=$_POST['Session_id'];
$mvalue[4]=$f_Session_id;
if (!is_numeric($f_Session_id))
$myTag++;
}
else //Post Data Not Available
$f_Session_id="NULL";



$mmode="";
if ($myTag==0)
{
$objUserlog->setUid($a_Uid);
$objUserlog->setLog_time_in($c_Log_time_in);
$objUserlog->setLog_time_out($d_Log_time_out);
$objUserlog->setClient_ip($e_Client_ip);
$objUserlog->setSession_id($f_Session_id);
$result=$objUserlog->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objUserlog->returnSql;
$col=1;
$_SESSION['msg']=$mmode;
if (!$result)
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(See Error Log File)";
$objUtility->saveSqlLog("Error",$sql);
}
else
{
//Clear the Required Field back to Entry Form
// Call MaxUid() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Uid
// Call MaxLog_time_in() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Log_time_in
// Call MaxLog_time_out() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Log_time_out
// Call MaxClient_ip() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Client_ip
// Call MaxSession_id() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="";//Session_id
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Userlog",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_userlog.php?tag=1');
?>
<a href=Form_userlog.php?tag=1>Back</a>
</body>
</html>
