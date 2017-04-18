<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.trg_time.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify



$objTrg_time=new Trg_time();
$Err="<font face=arial size=1 color=blue>";
$a_Code=$_POST['Code'];
$mvalue[0]=$a_Code;
if (!is_numeric($a_Code))
$myTag++;
$b_Timing=$_POST['Timing'];
$mvalue[1]=$b_Timing;
if ($objUtility->validate($b_Timing)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Timing)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Timing)==0)
$myTag++;
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objTrg_time->setCode($a_Code);
$objTrg_time->setTiming($b_Timing);
if ($_SESSION['update']==0)
{
$result=$objTrg_time->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objTrg_time->returnSql;
$col=1;
}
else
{
$result=$objTrg_time->UpdateRecord();
$col=$objTrg_time->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objTrg_time->returnSql;
}
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
// Call MaxCode() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Code
// Call MaxTiming() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Timing
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Trg_time",$sql);
$objUtility->Backup2Access("", $sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_trg_time.php?tag=1');
?>
<a href=Form_trg_time.php?tag=1>Back</a>
</body>
</html>
