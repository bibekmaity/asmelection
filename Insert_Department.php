<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.department.php';
require_once './class/class.deptype.php';
require_once './class/class.beeo.php';
require_once './class/class.lac.php';
require_once './class/class.sentence.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objDepartment=new Department();

//Start Verify
$allowedroll=3; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify


$Err="<font face=arial size=1 color=blue>";

$imode=$_POST['mode'];

if ($imode=="U")
$a_Depcode=$_POST['Depcode'];

if ($imode=="I")
$a_Depcode=$objDepartment->MaxDepcode();

$_SESSION['lastcode']=$a_Depcode;

$mvalue[0]=$a_Depcode;
if (!is_numeric($a_Depcode))
$myTag++;
$b_Dep_type=$_POST['Dep_type'];
$mvalue[1]=$b_Dep_type;
if ($objUtility->validate($b_Dep_type)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($b_Dep_type)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-2";
}

if (strlen($b_Dep_type)==0)
$myTag++;
}
else
$myTag++;
$c_Department=$objUtility->RemoveExtraSpace($_POST['Department']);
$mvalue[2]=$c_Department;
if ($objUtility->SimpleValidate($c_Department)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($c_Department)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-3";
}

if (strlen($c_Department)==0)
$myTag++;
}
else
$myTag++;
$e_Address=$_POST['Address'];
$mvalue[3]=$e_Address;

//echo "Address".$e_Address;
if ($objUtility->validate($e_Address)==true)
{
//Check for Unicode if required
//if ($objUtility->isUnicode($e_Address)==false)
{
$Err=$Err;
//$myTag++;
//$Err=$Err." Expect Unicode in Field-4";
}

if (strlen($e_Address)==0)
{
$e_Address="NULL";
}
}
else
$myTag++;

//echo "<br>Addressnext".$e_Address."<br>";
if(isset($_POST['Beeo']))
$f_Beeo_code=$_POST['Beeo'];
else
$f_Beeo_code=0;

$mvalue[4]=$f_Beeo_code;

if (!is_numeric($f_Beeo_code))
$myTag++;
$g_Dep_const=$_POST['Dep_const'];
$mvalue[5]=$g_Dep_const;
if (!is_numeric($g_Dep_const))
$myTag++;
$h_District=$_POST['District'];
$mvalue[6]=$h_District;
if ($objUtility->validate($h_District)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($h_District)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-7";
}

if (strlen($h_District)==0)
{
$h_District="NULL";
}
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objDepartment->setDepcode($a_Depcode);
$objDepartment->setDep_type($b_Dep_type);

if (isset($_POST['sentcase']))
{
$objC=new Sentence();
//echo "before-".$c_Department;
$c_Department=$objC->SentenceCase($c_Department);
//echo "after-".$c_Department;
//echo "before-".$e_Address;
$e_Address=$objC->SentenceCase($e_Address);
//echo "after-".$e_Address;
}

echo "<br>Address".$e_Address."<br>";

if($e_Address=="Null")
$e_Address="NULL";


$objDepartment->setDepartment($c_Department);
$objDepartment->setAddress($e_Address);
$objDepartment->setBeeo_code($f_Beeo_code);
$objDepartment->setDep_const($g_Dep_const);
$objDepartment->setDistrict($h_District);
if ($_SESSION['update']==0)
{
$result=$objDepartment->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objDepartment->returnSql;
}
else
{
$result=$objDepartment->UpdateRecord();
$mmode="Data Updated Successfully";
$sql=$objDepartment->returnSql;
}
$_SESSION['msg']=$mmode;
if (!$result)
{
$_SESSION['lastcode']=0;    
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(See Error Log File)";
$objUtility->saveSqlLog("Error",$sql);
}
else
{
//Clear the Required Field back to Entry Form
// Call MaxDepcode() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Depcode
// Call MaxDep_type() Function Here if available in class or required and Load in $mvalue[1]
//$mvalue[1]="";//Dep_type
$_SESSION['dtype']=$mvalue[1];
// Call MaxDepartment() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Department
// Call MaxAddress() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Address
// Call MaxBeeo_code() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="0";//Beeo_code
// Call MaxDep_const() Function Here if available in class or required and Load in $mvalue[5]
$mvalue[5]="";//Dep_const
// Call MaxDistrict() Function Here if available in class or required and Load in $mvalue[6]
//$mvalue[6]="";//District
//Succesfully update hence make an entry in sql log
$objUtility->saveSqlLog("Department",$sql);
$objUtility->Backup2Access("", $sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['lastcode']=0;
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_department.php?tag=1');
echo $sql;
?>
<a href=Form_department.php?tag=1>Back</a>
</body>
</html>
