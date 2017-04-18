<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.sex.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$Err="<font face=arial size=1 color=blue>";
$a_Code=$_POST['Code'];
$mvalue[0]=$a_Code;
if ($objUtility->validate($a_Code)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($a_Code)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-1";
}

if (strlen($a_Code)==0)
$myTag++;
}
else
$myTag++;
$b_Detail=$_POST['Detail'];
$mvalue[1]=$b_Detail;
if ($objUtility->validate($b_Detail)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Detail)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Detail)==0)
{
$b_Detail="NULL";
}
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objSex=new Sex();
$objSex->setCode($a_Code);
$objSex->setDetail($b_Detail);
if ($_SESSION['update']==0)
{
$result=$objSex->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objSex->returnSql;
}
else
{
$result=$objSex->UpdateRecord();
$mmode="Data Updated Successfully";
$sql=$objSex->returnSql;
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
// Call MaxDetail() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Detail
//Succesfully update hence make an entry in sql log
$objUtility->saveSqlLog("Sex",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_sex.php?tag=1');
?>
<a href=Form_sex.php?tag=1>Back</a>
</body>
</html>
