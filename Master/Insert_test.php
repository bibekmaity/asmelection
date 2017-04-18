<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.test.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objTest=new Test();
$Err="<font face=arial size=1 color=blue>";
if (isset($_POST['Date1'])) //If HTML Field is Availbale
{
$a_Date1=$_POST['Date1'];
$mvalue[0]=$a_Date1;
if ($objUtility->isdate($a_Date1)==false)
$myTag++;
else
$a_Date1=$objUtility->to_mysqldate($a_Date1);
}
else //Post Data Not Available
$a_Date1="NULL";
if (isset($_POST['Offset'])) //If HTML Field is Availbale
{
$b_Offset=$_POST['Offset'];
$mvalue[1]=$b_Offset;
if (!is_numeric($b_Offset))
$myTag++;
}
else //Post Data Not Available
$b_Offset="NULL";
if (isset($_POST['Date2'])) //If HTML Field is Availbale
{
$c_Date2=$_POST['Date2'];
$mvalue[2]=$c_Date2;
if ($objUtility->isdate($c_Date2)==false)
{
if (strlen($c_Date2)==0)
{
$c_Date2="NULL";
}
else
$myTag++;
}
else
$c_Date2=$objUtility->to_mysqldate($c_Date2);
}
else //Post Data Not Available
$c_Date2="NULL";


$mmode="";
if ($myTag==0)
{
$objTest->setDate1($a_Date1);
$objTest->setOffset($b_Offset);
$objTest->setDate2($c_Date2);
if ($_SESSION['update']==0)
{
$result=$objTest->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objTest->returnSql;
$col=1;
}
else
{
$result=$objTest->UpdateRecord();
$col=$objTest->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objTest->returnSql;
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
// Call MaxDate1() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Date1
// Call MaxOffset() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Offset
// Call MaxDate2() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Date2
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Test",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_test.php?tag=1');
?>
<a href=Form_test.php?tag=1>Back</a>
</body>
</html>
