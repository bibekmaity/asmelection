<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.countinghall.php';
require_once '../class/class.lac.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objCountinghall=new Countinghall();
$Err="<font face=arial size=1 color=blue>";

//Start Validation //Hall

if (isset($_POST['Hall'])) //If HTML Field is Availbale
{
$a_Hall=$_POST['Hall'];
$mvalue[0]=$a_Hall;
if (!is_numeric($a_Hall))
$myTag++;
}
else //Post Data Not Available
$a_Hall="NULL";


//Start Validation //Lac

if (isset($_POST['Lac'])) //If HTML Field is Availbale
{
$b_Lac=$_POST['Lac'];
$mvalue[1]=$b_Lac;
if (is_numeric($b_Lac)==false)
{
$b_Lac="NULL";
}
}
else //Post Data Not Available
$b_Lac="NULL";


//Start Validation //Start_table

if (isset($_POST['Start_table'])) //If HTML Field is Availbale
{
$c_Start_table=$_POST['Start_table'];
$mvalue[2]=$c_Start_table;
if (is_numeric($c_Start_table)==false)
{
$c_Start_table="NULL";
}
}
else //Post Data Not Available
$c_Start_table="NULL";


//Start Validation //No_of_table

if (isset($_POST['No_of_table'])) //If HTML Field is Availbale
{
$d_No_of_table=$_POST['No_of_table'];
$mvalue[3]=$d_No_of_table;
if (is_numeric($d_No_of_table)==false)
{
$d_No_of_table="NULL";
}
}
else //Post Data Not Available
$d_No_of_table="NULL";


//Start Validation //Ro_name

if (isset($_POST['Ro_name'])) //If HTML Field is Availbale
{
$e_Ro_name=$_POST['Ro_name'];
$mvalue[4]=$e_Ro_name;
if ($objUtility->validate($e_Ro_name,40)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($e_Ro_name)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($e_Ro_name)==0)
{
$e_Ro_name="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$e_Ro_name="NULL";



$mmode="";
if ($myTag==0)
{
$objCountinghall->setHall($a_Hall);
$objCountinghall->setLac($b_Lac);
$objCountinghall->setStart_table($c_Start_table);
$objCountinghall->setNo_of_table($d_No_of_table);
$objCountinghall->setRo_name($e_Ro_name);
if ($_SESSION['update']==0)
{
$result=$objCountinghall->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objCountinghall->returnSql;
$col=1;
}
else
{
$result=$objCountinghall->UpdateRecord();
$col=$objCountinghall->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objCountinghall->returnSql;
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
// Call MaxHall() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]="";//Hall
// Call MaxLac() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Lac
// Call MaxStart_table() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Start_table
// Call MaxNo_of_table() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//No_of_table
// Call MaxRo_name() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="";//Ro_name
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Countinghall",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_countinghall.php?tag=1');
?>
<a href=Form_countinghall.php?tag=1>Back</a>
</body>
</html>
