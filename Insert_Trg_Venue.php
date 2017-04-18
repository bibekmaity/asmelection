<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
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


$objTrg_venue=new Trg_venue();
$Err="<font face=arial size=1 color=blue>";
$a_Venue_code=$_POST['Venue_code'];
$mvalue[0]=$a_Venue_code;
if (!is_numeric($a_Venue_code))
$myTag++;
$b_Venue_name=$_POST['Venue_name'];
$mvalue[1]=$b_Venue_name;
if ($objUtility->validate($b_Venue_name)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Venue_name)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Venue_name)==0)
$myTag++;
}
else
$myTag++;


$mmode="";
if ($myTag==0)
{
$objTrg_venue->setVenue_code($a_Venue_code);
$objTrg_venue->setVenue_name($b_Venue_name);
if ($_SESSION['update']==0)
{
$result=$objTrg_venue->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objTrg_venue->returnSql;
$col=1;
}
else
{
$result=$objTrg_venue->UpdateRecord();
$col=$objTrg_venue->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objTrg_venue->returnSql;
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
$mvalue[0]="";//Venue_code
// Call MaxVenue_name() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Venue_name
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Trg_venue",$sql);
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
header( 'Location: Form_trg_venue.php?tag=1');
?>
<a href=Form_trg_venue.php?tag=1>Back</a>
</body>
</html>
