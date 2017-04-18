<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.beeo.php';

//Start Verify
$objUtility=new Utility();
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objBeeo=new Beeo();
$Err="<font face=arial size=1 color=blue>";
$a_Code=$_POST['Code'];
$mvalue[0]=$a_Code;
if (!is_numeric($a_Code))
$myTag++;
$b_Name=$_POST['Name'];
$mvalue[1]=$b_Name;
if ($objUtility->validate($b_Name)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($b_Name)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-2";
}

if (strlen($b_Name)==0)
{
$b_Name="NULL";
}
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objBeeo->setCode($a_Code);
$objBeeo->setName($b_Name);
if ($_SESSION['update']==0)
{
$result=$objBeeo->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objBeeo->returnSql;
$col=1;
}
else
{
$result=$objBeeo->UpdateRecord();
$col=$objBeeo->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objBeeo->returnSql;
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
// Call MaxName() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Name
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Beeo",$sql);
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
header( 'Location: Form_beeo.php?tag=1');
?>
<a href=Form_beeo.php?tag=1>Back</a>
</body>
</html>
