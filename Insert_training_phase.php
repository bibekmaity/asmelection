<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.training_phase.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objTraining_phase=new Training_phase();
$Err="<font face=arial size=1 color=blue>";
if (isset($_POST['Phase_no'])) //If HTML Field is Availbale
{
$a_Phase_no=$_POST['Phase_no'];
$mvalue[0]=$a_Phase_no;
if (!is_numeric($a_Phase_no))
$myTag++;
}
else //Post Data Not Available
$a_Phase_no="NULL";
if (isset($_POST['Election_district'])) //If HTML Field is Availbale
{
$c_Election_district=$_POST['Election_district'];
$mvalue[1]=$c_Election_district;
if ($objUtility->SimpleValidate($c_Election_district)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($c_Election_district)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($c_Election_district)==0)
{
$c_Election_district="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$c_Election_district="NULL";
if (isset($_POST['Letterno'])) //If HTML Field is Availbale
{
$d_Letterno=$_POST['Letterno'];
$mvalue[2]=$d_Letterno;
if ($objUtility->SimpleValidate($d_Letterno)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($d_Letterno)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($d_Letterno)==0)
{
$d_Letterno="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$d_Letterno="NULL";
if (isset($_POST['Letter_date'])) //If HTML Field is Availbale
{
$e_Letter_date=$_POST['Letter_date'];
$mvalue[3]=$e_Letter_date;
if ($objUtility->isdate($e_Letter_date)==false)
{
if (strlen($e_Letter_date)==0)
{
$e_Letter_date="NULL";
}
else
$myTag++;
}
else
$e_Letter_date=$objUtility->to_mysqldate($e_Letter_date);
}
else //Post Data Not Available
$e_Letter_date="NULL";
if (isset($_POST['Signature'])) //If HTML Field is Availbale
{
$f_Signature=$_POST['Signature'];
$mvalue[4]=$f_Signature;
if ($objUtility->SimpleValidate($f_Signature)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($f_Signature)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($f_Signature)==0)
{
$f_Signature="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$f_Signature="NULL";


$mmode="";
if ($myTag==0)
{
$objTraining_phase->setPhase_no($a_Phase_no);
//$objTraining_phase->setPhase_name("Pre Grouping Training");
$objTraining_phase->setElection_district($c_Election_district);
$objTraining_phase->setLetterno($d_Letterno);
$objTraining_phase->setLetter_date($e_Letter_date);
$objTraining_phase->setSignature($f_Signature);
if ($_SESSION['update']==0)
{
$result=$objTraining_phase->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objTraining_phase->returnSql;
$col=1;
}
else
{
$result=$objTraining_phase->UpdateRecord();
$col=$objTraining_phase->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objTraining_phase->returnSql;
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
$objTraining_phase->ExecuteQuery("update party_calldate set edistrict='".$c_Election_district."'");    
$objTraining_phase->ExecuteQuery("update Training_phase set Election_district='".$c_Election_district."'");    
//Clear the Required Field back to Entry Form
// Call MaxPhase_no() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Phase_no
// Call MaxElection_district() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Election_district
// Call MaxLetterno() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Letterno
// Call MaxLetter_date() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Letter_date
// Call MaxSignature() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="";//Signature
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Training_phase",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_training_phase.php?tag=1');
?>
<a href=Form_training_phase.php?tag=1>Back</a>
</body>
</html>
