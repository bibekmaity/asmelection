<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.party_calldate.php';

//Start Verify
$objUtility=new Utility();
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objPsname=new Psname();
$Err="<font face=arial size=1 color=blue>";
$b_Lac=$_POST['Lac'];
$mvalue[0]=$b_Lac;
if (!is_numeric($b_Lac))
$myTag++;

if ($_SESSION['update']==1) //update mode
$c_Psno=$_POST['Psno'];
else 
{    
$objPsname->setLac($mvalue[0]);
$c_Psno=$objPsname->maxPsno ();   
}

$mvalue[1]=$c_Psno;

if (!is_numeric($c_Psno))
$myTag++;
$d_Part_no=$_POST['Part_no'];
$mvalue[2]=$d_Part_no;
if ($objUtility->validate($d_Part_no)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($d_Part_no)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($d_Part_no)==0)
$myTag++;
}
else
$myTag++;
$e_Psname=$_POST['Psname'];
$mvalue[3]=$e_Psname;
if ($objUtility->validate($e_Psname)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($e_Psname)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-4";
}

if (strlen($e_Psname)==0)
$myTag++;
}
else
$myTag++;
$f_Address=$_POST['Address'];
$mvalue[4]=$f_Address;
if ($objUtility->validate($f_Address)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($f_Address)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($f_Address)==0)
{
$f_Address="NULL";
}
}
else
$myTag++;
$g_Male=$_POST['Male'];
$mvalue[5]=$g_Male;
if (!is_numeric($g_Male))
$myTag++;
$h_Female=$_POST['Female'];
$mvalue[6]=$h_Female;
if (!is_numeric($h_Female))
$myTag++;

$l_Forthpoling_required=0;
if ($g_Male+$h_Female>1199)
$l_Forthpoling_required=1;

$mvalue[7]=$l_Forthpoling_required;
$m_Reporting_tag=$_POST['Reporting_tag'];
$mvalue[8]=$m_Reporting_tag;
if (is_numeric($m_Reporting_tag)==false)
{
$m_Reporting_tag="NULL";
}

if(isset($_POST['Sensitivity']))
$Sensitivity=$_POST['Sensitivity'];
else
$myTag=$myTag+1;    


$mmode="";
if ($myTag==0)
{
    
$objPsname->setLac($b_Lac);
$objPsname->setPsno($c_Psno);

$objLac=new Lac();
$objLac->setCode($b_Lac);
if ($objLac->EditRecord())
$objPsname->setHpc ($objLac->getHpccode ());
else
$objPsname->setHpc ("0"); 
$objPsname->setPart_no($d_Part_no);
$objPsname->setPsname($e_Psname);
$objPsname->setAddress($f_Address);
$objPsname->setMale($g_Male);
$objPsname->setFemale($h_Female);
$objPsname->setForthpoling_required($l_Forthpoling_required);
$objPsname->setReporting_tag($m_Reporting_tag);
$objPsname->setSensitivity($Sensitivity);
if ($_SESSION['update']==0)
{
$result=$objPsname->SaveRecord();
$mmode="Data Entered Successfully";
$sql=$objPsname->returnSql;
$col=1;
}
else
{
$result=$objPsname->UpdateRecord();
$col=$objPsname->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objPsname->returnSql;
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
// Call MaxLac() Function Here if available in class or required and Load in $mvalue[0]
//$mvalue[0]="";//Lac
// Call MaxPsno() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]=$objPsname->maxPsno();
// Call MaxPart_no() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Part_no
// Call MaxPsname() Function Here if available in class or required and Load in $mvalue[3]
$mvalue[3]="";//Psname
// Call MaxAddress() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="";//Address
// Call MaxMale() Function Here if available in class or required and Load in $mvalue[5]
$mvalue[5]="";//Male
// Call MaxFemale() Function Here if available in class or required and Load in $mvalue[6]
$mvalue[6]="";//Female
// Call MaxForthpoling_required() Function Here if available in class or required and Load in $mvalue[7]
$mvalue[7]="";//Forthpoling_required
$mvalue[8]="1";
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Psname",$sql);
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
header( 'Location: Form_psname.php?tag=1');
?>
<a href=Form_psname.php?tag=1>Back</a>
</body>
</html>
