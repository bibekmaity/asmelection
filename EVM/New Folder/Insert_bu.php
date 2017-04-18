<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once './class/class.bu.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objBu=new Bu();
$Err="<font face=arial size=1 color=blue>";
$a_Bu_code=$_POST['Bu_code'];
$mvalue[0]=$a_Bu_code;
if (!is_numeric($a_Bu_code))
$myTag++;
$b_Bu_number=$_POST['Bu_number'];
$mvalue[1]=$b_Bu_number;
if ($objUtility->validate($b_Bu_number)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Bu_number)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Bu_number)==0)
$myTag++;
}
else
$myTag++;
$c_Trunck_number=$_POST['Trunck_number'];
$mvalue[2]=$c_Trunck_number;
if (is_numeric($c_Trunck_number)==false)
{
$c_Trunck_number="NULL";
}

$cat=$_POST['Cat'];
$mmode="";
if ($myTag==0)
{
$objBu->setBu_code($a_Bu_code);
$objBu->setBu_number($b_Bu_number);
$objBu->setRnumber(rand());
$objBu->setTrunck_number($c_Trunck_number);
$objBu->setCategory($cat);
if(isset($_POST['Trg']))
$objBu->setUsed("T");
else
$objBu->setUsed("N");
if ($_SESSION['update']==0)
{
$result=$objBu->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objBu->returnSql;
$col=1;
}
else
{
$result=$objBu->UpdateRecord();
$col=$objBu->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objBu->returnSql;
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
// Call MaxBu_code() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Bu_code
// Call MaxBu_number() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Bu_number
// Call MaxTrunck_number() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Trunck_number
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Bu",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_bu.php?tag=1');
?>
<a href=Form_bu.php?tag=1>Back</a>
</body>
</html>
