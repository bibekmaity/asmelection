<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.trg_hall.php';
require_once './class/class.trg_venue.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify



$objTrg_hall=new Trg_hall();
$Err="<font face=arial size=1 color=blue>";
$a_Venue_code=$_POST['Venue_code'];
$mvalue[0]=$a_Venue_code;
if (!is_numeric($a_Venue_code))
$myTag++;
$b_Rsl=$_POST['Rsl'];
$mvalue[1]=$b_Rsl;
if (!is_numeric($b_Rsl))
$myTag++;
$c_Hall_number=$_POST['Hall_number'];
$mvalue[2]=$c_Hall_number;
if ($objUtility->validate($c_Hall_number)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($c_Hall_number)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($c_Hall_number)==0)
{
$c_Hall_number="NULL";
}
}
else
$myTag++;
$d_Hall_capacity=$_POST['Hall_capacity'];
$mvalue[3]=$d_Hall_capacity;
if (is_numeric($d_Hall_capacity)==false)
{
$d_Hall_capacity="NULL";
}


$mmode="";
if ($myTag==0)
{
$objTrg_hall->setVenue_code($a_Venue_code);
$objTrg_hall->setRsl($b_Rsl);
$objTrg_hall->setHall_number($c_Hall_number);
$objTrg_hall->setHall_capacity($d_Hall_capacity);
if ($_SESSION['update']==0)
{
$result=$objTrg_hall->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objTrg_hall->returnSql;
$col=1;
}
else
{
$result=$objTrg_hall->UpdateRecord();
$col=$objTrg_hall->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objTrg_hall->returnSql;
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
// Call MaxVenue_code() Function Here if available in class or required and Load in $mvalue[0]
//$mvalue[0]="";//Venue_code
// Call MaxRsl() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Rsl
// Call MaxHall_number() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Hall_number
// Call MaxHall_capacity() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Hall_capacity
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Trg_hall",$sql);
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
header( 'Location: Form_trg_hall.php?tag=1');
?>
<a href=Form_trg_hall.php?tag=1>Back</a>
</body>
</html>
