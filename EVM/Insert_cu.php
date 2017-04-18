<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once './class/class.cu.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objCu=new Cu();
$Err="<font face=arial size=1 color=blue>";
$a_Cu_code=$_POST['Cu_code'];
$mvalue[0]=$a_Cu_code;
if (!is_numeric($a_Cu_code))
$myTag++;
$b_Cu_number=$_POST['Cu_number'];
$mvalue[1]=$b_Cu_number;
if ($objUtility->validate($b_Cu_number)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Cu_number)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Cu_number)==0)
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
$objCu->setCu_code($a_Cu_code);
$objCu->setCu_number($b_Cu_number);
$objCu->setRnumber(rand());
$objCu->setTrunck_number($c_Trunck_number);
$objCu->setCategory($cat);
if(isset($_POST['Trg']))
$objCu->setUsed("T");
else
$objCu->setUsed("N");

if ($_SESSION['update']==0)
{
$result=$objCu->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objCu->returnSql;
$col=1;
}
else
{
$result=$objCu->UpdateRecord();
$col=$objCu->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objCu->returnSql;
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
// Call MaxCu_code() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Cu_code
// Call MaxCu_number() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Cu_number
// Call MaxTrunck_number() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Trunck_number
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Cu",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_cu.php?tag=1');
?>
<a href=Form_cu.php?tag=1>Back</a>
</body>
</html>
