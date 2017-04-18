<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.designation.php';
require_once '../class/class.deptype.php';

//Start Verify
$objUtility=new Utility();
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objDesignation=new Designation();
$Err="<font face=arial size=1 color=blue>";
$a_Dep_type=$_POST['Dep_type'];
$mvalue[0]=$a_Dep_type;
if ($objUtility->validate($a_Dep_type)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($a_Dep_type)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-1";
}

if (strlen($a_Dep_type)==0)
{
$a_Dep_type="NULL";
}
}
else
$myTag++;
$b_Desig_code=$_POST['Desig_code'];
$mvalue[1]=$b_Desig_code;
if (!is_numeric($b_Desig_code))
$myTag++;
$c_Designation=$_POST['Designation'];
$mvalue[2]=$c_Designation;
if ($objUtility->validate($c_Designation)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($c_Designation)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-3";
}

if (strlen($c_Designation)==0)
{
$c_Designation="NULL";
}
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objDesignation->setDep_type($a_Dep_type);
$objDesignation->setDesig_code($b_Desig_code);
$objDesignation->setDesignation($c_Designation);
if ($_SESSION['update']==0)
{
$result=$objDesignation->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objDesignation->returnSql;
$col=1;
}
else
{
$result=$objDesignation->UpdateRecord();
$col=$objDesignation->colUpdated;
if ($col>0)
{
$mmode=$col." Column Updated";
$idlist=$objDesignation->DesigWisePidList($a_Dep_type,$_POST['OldDesignation']);
$objUtility->saveSqlLog("idlist",$objDesignation->returnSql);
$newsql="update poling set desig='".$c_Designation."' where slno in".$idlist;
if($objDesignation->ExecuteQuery($newsql))
{
$rowCommitted=$objDesignation->rowCommitted;
$mmode=$mmode."(Effected ".$rowCommitted." Rows in Poling Master)";
}
$objUtility->saveSqlLog("idlist",$newsql);
}
else
$mmode="Nothing to Update";
$sql=$objDesignation->returnSql;
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
// Call MaxDep_type() Function Here if available in class or required and Load in $mvalue[0]
//$mvalue[0]="";//Dep_type
// Call MaxDesig_code() Function Here if available in class or required and Load in $mvalue[1]
//$mvalue[1]="";//Desig_code
// Call MaxDesignation() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Designation
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Designation",$sql);
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
header( 'Location: Form_designation.php?tag=1');
?>
<a href=Form_designation.php?tag=1>Back</a>
</body>
</html>
