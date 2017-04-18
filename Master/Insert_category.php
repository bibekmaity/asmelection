<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.category.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objCategory=new Category();
$Err="<font face=arial size=1 color=blue>";
if (isset($_POST['Code'])) //If HTML Field is Availbale
{
$a_Code=$_POST['Code'];
$mvalue[0]=$a_Code;
if (!is_numeric($a_Code))
$myTag++;
}
else //Post Data Not Available
$a_Code="NULL";
if (isset($_POST['Name'])) //If HTML Field is Availbale
{
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
$myTag++;
}
else
$myTag++;
}
else //Post Data Not Available
$b_Name="NULL";
if (isset($_POST['Trgamount'])) //If HTML Field is Availbale
{
$c_Trgamount=$_POST['Trgamount'];
$mvalue[2]=$c_Trgamount;
if (is_numeric($c_Trgamount)==false)
{
$c_Trgamount="NULL";
}
}
else //Post Data Not Available
$c_Trgamount="NULL";
if (isset($_POST['Amount1'])) //If HTML Field is Availbale
{
$d_Amount1=$_POST['Amount1'];
$mvalue[3]=$d_Amount1;
if (is_numeric($d_Amount1)==false)
{
$d_Amount1="NULL";
}
}
else //Post Data Not Available
$d_Amount1="NULL";
if (isset($_POST['Amount2'])) //If HTML Field is Availbale
{
$e_Amount2=$_POST['Amount2'];
$mvalue[4]=$e_Amount2;
if (is_numeric($e_Amount2)==false)
{
$e_Amount2="NULL";
}
}
else //Post Data Not Available
$e_Amount2="NULL";
if (isset($_POST['Amount3'])) //If HTML Field is Availbale
{
$f_Amount3=$_POST['Amount3'];
$mvalue[5]=$f_Amount3;
if (is_numeric($f_Amount3)==false)
{
$f_Amount3="NULL";
}
}
else //Post Data Not Available
$f_Amount3="NULL";
if (isset($_POST['Amount4'])) //If HTML Field is Availbale
{
$g_Amount4=$_POST['Amount4'];
$mvalue[6]=$g_Amount4;
if (is_numeric($g_Amount4)==false)
{
$g_Amount4="NULL";
}
}
else //Post Data Not Available
$g_Amount4="NULL";


$mmode="";
if ($myTag==0)
{
$objCategory->setCode($a_Code);
//$objCategory->setName($b_Name);
$objCategory->setTrgamount($c_Trgamount);
$objCategory->setAmount1($d_Amount1);
$objCategory->setAmount2($e_Amount2);
$objCategory->setAmount3($f_Amount3);
$objCategory->setAmount4($g_Amount4);
if ($_SESSION['update']==0)
{
$result=$objCategory->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objCategory->returnSql;
$col=1;
}
else
{
$result=$objCategory->UpdateRecord();
$col=$objCategory->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objCategory->returnSql;
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
$mvalue[2]="0";
$mvalue[3]="0";
$mvalue[4]="0";
$mvalue[5]="0";
$mvalue[6]="0";
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Category",$sql);
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
header( 'Location: Form_category.php?tag=1');
?>
<a href=Form_category.php?tag=1>Back</a>
</body>
</html>
