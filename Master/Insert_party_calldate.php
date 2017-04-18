<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.party_calldate.php';

//Start Verify
$objUtility=new Utility();
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify



$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objParty_calldate=new Party_calldate();
$Err="<font face=arial size=1 color=blue>";
$a_Code=$_POST['Code'];
$mvalue[0]=$a_Code;
if (!is_numeric($a_Code))
$myTag++;
$b_Mydate=$_POST['Mydate'];
$mvalue[1]=$b_Mydate;
if ($objUtility->validate($b_Mydate)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($b_Mydate)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-2";
}

if (strlen($b_Mydate)==0)
{
$b_Mydate="NULL";
}
}
else
$myTag++;
$c_Polldate=$_POST['Polldate'];
$mvalue[2]=$c_Polldate;
if ($objUtility->validate($c_Polldate)==true)
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
$d_Mydate1=$_POST['Mydate1'];
$mvalue[3]=$d_Mydate1;
if ($objUtility->validate($d_Mydate1)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($d_Mydate1)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-4";
}

if (strlen($d_Mydate1)==0)
{
$d_Mydate1="NULL";
}
}
else
$myTag++;
$f_Assemble_place=$_POST['Assemble_place'];
$mvalue[4]=$f_Assemble_place;
if ($objUtility->validate($f_Assemble_place)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($f_Assemble_place)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($f_Assemble_place)==0)
{
$f_Assemble_place="NULL";
}
}
else
$myTag++;
$g_Poll_starttime=$_POST['Poll_starttime'];
$mvalue[5]=$g_Poll_starttime;
if ($objUtility->validate($g_Poll_starttime)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($g_Poll_starttime)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-6";
}

if (strlen($g_Poll_starttime)==0)
{
$g_Poll_starttime="NULL";
}
}
else
$myTag++;
$h_Poll_endtime=$_POST['Poll_endtime'];
$mvalue[6]=$h_Poll_endtime;
if ($objUtility->validate($h_Poll_endtime)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($h_Poll_endtime)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-7";
}

if (strlen($h_Poll_endtime)==0)
{
$h_Poll_endtime="NULL";
}
}
else
$myTag++;
$i_Mplace=$_POST['Mplace'];
$mvalue[7]=$i_Mplace;
if ($objUtility->validate($i_Mplace)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($i_Mplace)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-8";
}

if (strlen($i_Mplace)==0)
{
$i_Mplace="NULL";
}
}
else
$myTag++;
$j_Mdate=$_POST['Mdate'];
$mvalue[8]=$j_Mdate;
if ($objUtility->validate($j_Mdate)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($j_Mdate)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-9";
}

if (strlen($j_Mdate)==0)
{
$j_Mdate="NULL";
}
}
else
$myTag++;
$k_Msignature=$_POST['Msignature'];
$mvalue[9]=$k_Msignature;

//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($k_Msignature)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-10";
}

if (strlen($k_Msignature)==0)
{
$k_Msignature="NULL";
}



$mmode="";
if ($myTag==0)
{
$objParty_calldate->setCode($a_Code);
$objParty_calldate->setMydate($b_Mydate);
$objParty_calldate->setPolldate($c_Polldate);
$objParty_calldate->setMydate1($d_Mydate1);
$objParty_calldate->setAssemble_place($f_Assemble_place);
$objParty_calldate->setPoll_starttime($g_Poll_starttime);
$objParty_calldate->setPoll_endtime($h_Poll_endtime);
$objParty_calldate->setMplace($i_Mplace);
$objParty_calldate->setMdate($j_Mdate);
$objParty_calldate->setMsignature($k_Msignature);
if ($_SESSION['update']==0)
{
$result=$objParty_calldate->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objParty_calldate->returnSql;
$col=1;
}
else
{
$result=$objParty_calldate->UpdateRecord();
$col=$objParty_calldate->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objParty_calldate->returnSql;
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
// Call MaxMydate() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Mydate
// Call MaxPolldate() Function Here if available in class or required and Load in $mvalue[2]
//$mvalue[2]="";//Polldate
// Call MaxMydate1() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Mydate1
// Call MaxAssemble_place() Function Here if available in class or required and Load in $mvalue[4]
//$mvalue[4]="";//Assemble_place
// Call MaxPoll_starttime() Function Here if available in class or required and Load in $mvalue[5]
//$mvalue[5]="";//Poll_starttime
// Call MaxPoll_endtime() Function Here if available in class or required and Load in $mvalue[6]
//$mvalue[6]="";//Poll_endtime
// Call MaxMplace() Function Here if available in class or required and Load in $mvalue[7]
//$mvalue[7]="";//Mplace
// Call MaxMdate() Function Here if available in class or required and Load in $mvalue[8]
//$mvalue[8]="";//Mdate
// Call MaxMsignature() Function Here if available in class or required and Load in $mvalue[9]
//$mvalue[9]="";//Msignature
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Party_calldate",$sql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_party_calldate.php?tag=1');
?>
<a href=Form_party_calldate.php?tag=1>Back</a>
</body>
</html>
