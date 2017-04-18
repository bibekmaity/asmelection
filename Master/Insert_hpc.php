<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
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
$objHpc=new Hpc();
$Err="<font face=arial size=1 color=blue>";
$a_Hpccode=$_POST['Hpccode'];
$mvalue[0]=$a_Hpccode;
if (!is_numeric($a_Hpccode))
$myTag++;
$b_Hpcname=$_POST['Hpcname'];
$mvalue[1]=$b_Hpcname;
if ($objUtility->validate($b_Hpcname)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($b_Hpcname)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-2";
}

if (strlen($b_Hpcname)==0)
{
$b_Hpcname="NULL";
}
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objHpc->setHpccode($a_Hpccode);
$objHpc->setHpcname($b_Hpcname);
if ($_SESSION['update']==0)
{
$result=$objHpc->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objHpc->returnSql;
$col=1;
}
else
{
$result=$objHpc->UpdateRecord();
$col=$objHpc->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objHpc->returnSql;
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
$mvalue[0]="0";
// Call MaxHpcname() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Hpcname
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Hpc",$sql);
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
header( 'Location: Form_hpc.php?tag=1');
?>
<a href=Form_hpc.php?tag=1>Back</a>
</body>
</html>
