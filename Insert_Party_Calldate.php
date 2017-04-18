<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.party_calldate.php';

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



$objParty_calldate=new Party_calldate();
$Err="<font face=arial size=1 color=blue>";


if (isset($_POST['Polldate'])) //If HTML Field is Availbale
{
$c_Polldate=$_POST['Polldate'];
$mvalue[2]=$c_Polldate;
if ($objUtility->isdate($c_Polldate)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($c_Polldate)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($c_Polldate)==0)
{
$c_Polldate="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$c_Polldate="NULL";
if (isset($_POST['Assemble_place'])) //If HTML Field is Availbale
{
$f_Assemble_place=$_POST['Assemble_place'];
$mvalue[3]=$f_Assemble_place;
if ($objUtility->SimpleValidate($f_Assemble_place)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($f_Assemble_place)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-4";
}

if (strlen($f_Assemble_place)==0)
{
$f_Assemble_place="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$f_Assemble_place="NULL";
if (isset($_POST['Poll_starttime'])) //If HTML Field is Availbale
{
$g_Poll_starttime=$_POST['Poll_starttime'];
$mvalue[4]=$g_Poll_starttime;
if ($objUtility->SimpleValidate($g_Poll_starttime)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($g_Poll_starttime)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($g_Poll_starttime)==0)
{
$g_Poll_starttime="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$g_Poll_starttime="NULL";
if (isset($_POST['Poll_endtime'])) //If HTML Field is Availbale
{
$h_Poll_endtime=$_POST['Poll_endtime'];
$mvalue[5]=$h_Poll_endtime;
if ($objUtility->SimpleValidate($h_Poll_endtime)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($h_Poll_endtime)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-6";
}

if (strlen($h_Poll_endtime)==0)
{
$h_Poll_endtime="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$h_Poll_endtime="NULL";
if (isset($_POST['Mplace'])) //If HTML Field is Availbale
{
$i_Mplace=$_POST['Mplace'];
$mvalue[6]=$i_Mplace;
if ($objUtility->SimpleValidate($i_Mplace)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($i_Mplace)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-7";
}

if (strlen($i_Mplace)==0)
{
$i_Mplace="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$i_Mplace="NULL";
if (isset($_POST['Mdate'])) //If HTML Field is Availbale
{
$j_Mdate=$_POST['Mdate'];
$mvalue[7]=$j_Mdate;
if ($objUtility->SimpleValidate($j_Mdate)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($j_Mdate)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-8";
}

if (strlen($j_Mdate)==0)
{
$j_Mdate="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$j_Mdate="NULL";
if (isset($_POST['Msignature'])) //If HTML Field is Availbale
{
$k_Msignature=$_POST['Msignature'];
$mvalue[8]=$k_Msignature;
if ($objUtility->SimpleValidate($k_Msignature)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($k_Msignature)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-9";
}

if (strlen($k_Msignature)==0)
{
$k_Msignature="NULL";
}
}
else
$myTag++;
}
else //Post Data Not Available
$k_Msignature="NULL";


$mmode="";
if ($myTag==0)
{
$pdate=$objUtility->to_mysqldate($c_Polldate);
//Decrease date by -1
$b_Mydate=$objUtility->datePlusMinus($pdate, -1);  
//convert to dd/mm/yyyy
$b_Mydate=$objUtility->to_date($b_Mydate);

$objParty_calldate->setCode(1);
$objParty_calldate->setMydate($b_Mydate);
$objParty_calldate->setPolldate($c_Polldate);
$objParty_calldate->setAssemble_place($f_Assemble_place);
$objParty_calldate->setPoll_starttime($g_Poll_starttime);
$objParty_calldate->setPoll_endtime($h_Poll_endtime);
$objParty_calldate->setMplace($i_Mplace);
$objParty_calldate->setMdate($j_Mdate);
$objParty_calldate->setMsignature($k_Msignature);
//update for Code=1
if($objParty_calldate->RecordAvailable())
$objParty_calldate->UpdateRecord();
else
$objParty_calldate->SaveRecord();
$objUtility->Backup2Access("", $objParty_calldate->returnSql);
//update for Code=0
$b_Mydate=$objUtility->datePlusMinus($pdate, -2);  
//convert to dd/mm/yyyy
$b_Mydate=$objUtility->to_date($b_Mydate);
$objParty_calldate->setCode(0);
$objParty_calldate->setMydate($b_Mydate);
if($objParty_calldate->RecordAvailable())
$objParty_calldate->UpdateRecord();
else
$objParty_calldate->SaveRecord();
$objUtility->Backup2Access("", $objParty_calldate->returnSql);
}


header( 'Location: ManageReportingDate.php?tag=1');
?>
<a href=Form_party_calldate.php?tag=1>Back</a>
</body>
</html>
