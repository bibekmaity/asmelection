<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.lac.php';
require_once '../class/class.hpc.php';

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
$objLac=new Lac();
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
$c_Ro_sign=$_POST['Ro_sign'];
$mvalue[2]=$c_Ro_sign;

echo "ro sign".$c_Ro_sign;

if ($objUtility->validate($c_Ro_sign)==false)
{
$c_Ro_sign="NULL";
}


$d_Hpccode=$_POST['Hpccode'];
$mvalue[3]=$d_Hpccode;
if (is_numeric($d_Hpccode)==false)
{
$d_Hpccode="NULL";
}
//validate RO Detail
if(isset($_POST['Ro_detail']))
{
$mvalue[5]=$_POST['Ro_detail'];
if($objUtility->validate($mvalue[5])==false)
$myTag++;
}
else
{
$mvalue[5]="";
}


$mmode="";
if ($myTag==0)
{
$objLac->setCode($a_Code);
$objLac->setName($b_Name);
$objLac->setRo_sign($c_Ro_sign);
$objLac->setHpccode($d_Hpccode);
$objLac->setRo_detail($mvalue[5]);
if ($_SESSION['update']==0)
{
$result=$objLac->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objLac->returnSql;
$col=1;
}
else
{
$result=$objLac->UpdateRecord();
$col=$objLac->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objLac->returnSql;
}
$_SESSION['msg']=$mmode;

//echo "sql".$sql;


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
// Call MaxRo_sign() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Ro_sign
// Call MaxHpccode() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Hpccode
$mvalue[5]="";
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Lac",$sql);
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
header( 'Location: Form_lac.php?tag=1');
?>
<a href=Form_lac.php?tag=1>Back</a>
</body>
</html>
