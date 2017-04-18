<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.sex.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.cell.php';
require_once './class/class.sentence.php';
require_once './class/class.poling_history.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$objPoling=new Poling();

$objPH=new Poling_history();
$dt=date('Y-m-d');
$user=$_SESSION['uid'];


//Start Verify
$allowedroll=3; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

$Err="<font face=arial size=1 color=blue>";

if ($_SESSION['update']==1) //Update Mode'

    
$a_Slno=$_POST['Slno'];
else
$a_Slno=$objPoling->maxSlno ();
$mvalue[0]=$a_Slno;



if (!is_numeric($a_Slno))
$myTag++;
$b_Rslno=$a_Slno;


$b_R_Lac=$_POST['R_Lac'];
$mvalue[1]=$b_R_Lac;
if (!is_numeric($b_R_Lac))
$myTag++;


$c_Name=$_POST['Name']." ";
$mvalue[2]=$c_Name;


if ($objUtility->validate($c_Name)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($c_Name)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($c_Name)==0)
$myTag++;
}
else
$myTag++;
$d_Desig=$_POST['Desig'];
$mvalue[3]=$d_Desig;
if ($objUtility->validate($d_Desig)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($d_Desig)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-4";
}

if (strlen($d_Desig)==0)
$myTag++;
}
else
$myTag++;
$h_Sex=$_POST['Sex'];
$mvalue[4]=$h_Sex;
if ($objUtility->validate($h_Sex)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($h_Sex)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($h_Sex)==0)
{
$h_Sex="NULL";
}
}
else
$myTag++;
$i_Age=$_POST['Age'];
$mvalue[5]=$i_Age;
if (is_numeric($i_Age)==false)
{
$i_Age="NULL";
}
$j_Homeconst=$_POST['Homeconst'];
$mvalue[6]=$j_Homeconst;
if (!is_numeric($j_Homeconst))
$myTag++;
$k_Placeofresidence=$_POST['Placeofresidence'];
$mvalue[7]=$k_Placeofresidence;
if ($objUtility->validate($k_Placeofresidence)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($k_Placeofresidence)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-8";
}

if (strlen($k_Placeofresidence)==0)
{
$k_Placeofresidence="NULL";
}
}
else
$myTag++;
$l_Basic=$_POST['Basic'];
$mvalue[8]=$l_Basic;
if (is_numeric($l_Basic)==false)
{
$l_Basic="NULL";
}
$m_Scale=$_POST['Scale'];
$mvalue[9]=$m_Scale;
if ($objUtility->validate($m_Scale)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($m_Scale)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-10";
}

if (strlen($m_Scale)==0)
{
$m_Scale="NULL";
}
}
else
$myTag++;
$n_Gradepay=$_POST['Gradepay'];
$mvalue[10]=$n_Gradepay;
if (is_numeric($n_Gradepay)==false)
{
$n_Gradepay="NULL";
}
$q_Pollcategory=$_POST['Pollcategory'];
$mvalue[11]=$q_Pollcategory;
if (is_numeric($q_Pollcategory)==false)
{
$q_Pollcategory="NULL";
}
if (isset($_POST['Cellname']))
$r_Cellname=$_POST['Cellname'];
else
$r_Cellname="0";

$mvalue[12]=$r_Cellname;
if (is_numeric($r_Cellname)==false)
{
$r_Cellname="NULL";
}
$v_Gazeted=$_POST['Gazeted'];
$mvalue[13]=$v_Gazeted;
if ($objUtility->validate($v_Gazeted)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($v_Gazeted)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-14";
}

if (strlen($v_Gazeted)==0)
$myTag++;
}
else
$myTag++;
$w_Phone=$_POST['Phone'];
$mvalue[14]=$w_Phone;
if ($objUtility->validate($w_Phone)==true)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($w_Phone)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-15";
}

if (strlen($w_Phone)==0)
{
$w_Phone="NULL";
}
}
else
$myTag++;
$ab_Dor=$_POST['Dor'];
$mvalue[15]=$ab_Dor;
if ($objUtility->isdate($ab_Dor)==false)
{
if (strlen($ab_Dor)==0)
{
$ab_Dor="NULL";
}
else
$myTag++;
}
else
$ab_Dor=$objUtility->to_mysqldate($ab_Dor);
$ae_Remarks=$objUtility->RemoveExtraSpace($_POST['Remarks']);
$mvalue[16]=$ae_Remarks;
if ($objUtility->SimpleValidate($ae_Remarks)==true && strlen($ae_Remarks)<251)
{
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($ae_Remarks)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-17";
}

if (strlen($ae_Remarks)==0)
{
$ae_Remarks="NULL";
}
}
else
$myTag++;

//PS NO
$psvsl="";
if(isset($_POST['Psno']))
{
$ps=$_POST['Psno'];
if ($objUtility->validate($ps)==true)
$psvsl=$ps."/";
else
$psvsl="/";
}
else
$psvsl="/";

//Voter Serial No
if(isset($_POST['Vsl']))
{
$vsl=$_POST['Vsl'];
if (is_numeric($vsl))
$psvsl=$psvsl.$vsl."/";
else
$psvsl=$psvsl."/";    
}
else
$psvsl=$psvsl."/";    
//Voter Epic NO
$patern="/[A-Z]{3}[0-9]{7}/"; // First 3 Charactr as A to Z and rest 7 char from 0 to 9
$patern1="/[A-Za-Z]{3}[0-9]{7}/"; // First 3 Charactr as(A to Z or a to Z) and rest 7 char from 0 to 9

if(isset($_POST['Epic']))
{
$epic=strtoupper($_POST['Epic']);
if(preg_match($patern,$epic))
$psvsl=$psvsl.$epic;
}

$mmode="";

if ($myTag==0)
{
//Retrive department detail from session variabnle  
  
$deparray=$_SESSION['deparray']; 
$objPoling->setDepcode($deparray['Depcode']);
$objPoling->setDepartment($deparray['Depname']);
$objPoling->setDepconst($deparray['Depconst']);
$objPoling->setBeeo_code($deparray['Beeo']);

$objPoling->setSlno($a_Slno);
$objPoling->setR_lac($b_R_Lac);
$c_Name=  trim(strtoupper($c_Name));
$objPoling->setName($c_Name);
$objPoling->setDesig($d_Desig);
$objPoling->setSex($h_Sex);
$objPoling->setAge($i_Age);
$objPoling->setHomeconst($j_Homeconst);
$objPoling->setPsno_Vsl($psvsl);
$objC=new Sentence();
if ($k_Placeofresidence!="NULL")
{
$k_Placeofresidence=trim($objC->SentenceCase($k_Placeofresidence));
}
$objPoling->setPlaceofresidence($k_Placeofresidence);
$objPoling->setBasic($l_Basic);
//$objPoling->setScale($m_Scale);
$objPoling->setGradepay($n_Gradepay);
$objPoling->setPollcategory($q_Pollcategory);
$objPoling->setCellname($r_Cellname);
$objPoling->setGazeted($v_Gazeted);
$objPoling->setPhone($w_Phone);
$objPoling->setDor($ab_Dor);
if ($ae_Remarks!="NULL")
$ae_Remarks=trim($objC->SentenceCase($ae_Remarks));

$objPoling->setRemarks($ae_Remarks);

if(($objPoling->FirstLevelCompleted() && $q_Pollcategory<6) ||($objPoling->Randomised(7) && $q_Pollcategory==7))
$objPoling->setSelected ("Y");

if ($_SESSION['update']==0)
{
$result=$objPoling->SaveRecord();
$mmode="Detail of <b>".$objC->SentenceCase($c_Name)."</b> Entered Successfully";
$sql=$objPoling->returnSql;
//now add an entry in Poling History table
$objPH->setPid($a_Slno);
$objPH->setRsl($objPH->maxRsl($a_Slno));
$objPH->setE_date($dt);
$objPH->setUser_name($user);
$objPH->setHistory("New[".$objPoling->FieldUpdated."]");
$objPH->SaveRecord();
echo $objPoling->FieldUpdated;
echo "<br>";
echo $objPH->returnSql;
$col=1;
}
else
{
$result=$objPoling->UpdateRecord();
$sql=$objPoling->returnSql;
//echo $sql."<br>";
//echo $objPoling->rowCommitted;

$col=$objPoling->colUpdated;    
//now add an entry in Poling History table
if ($col>0)
{
$mmode="Updated Detail(".$col." Column) of <b>".$objC->SentenceCase($c_Name)."</b>";
$objPH->setPid($a_Slno);
$objPH->setRsl($objPH->maxRsl($a_Slno));
$objPH->setE_date($dt);
$objPH->setUser_name($user);
$objPH->setHistory($objPoling->updateList);
$objPH->SaveRecord();
}
else
$mmode="Nothing to Update";    
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
// Call MaxSlno() Function Here if available in class or required and Load in $mvalue[0]
$mvalue[0]=$objPoling->maxSlno();
// Call MaxRslno() Function Here if available in class or required and Load in $mvalue[1]
$mvalue[1]="";//Rslno
// Call MaxName() Function Here if available in class or required and Load in $mvalue[2]
$mvalue[2]="";//Name
// Call MaxDesig() Function Here if available in class or required and Load in $mvalue[3]
//$mvalue[3]="";//Desig
// Call MaxSex() Function Here if available in class or required and Load in $mvalue[4]
$mvalue[4]="";//Sex
// Call MaxAge() Function Here if available in class or required and Load in $mvalue[5]
$mvalue[5]="";//Age
// Call MaxHomeconst() Function Here if available in class or required and Load in $mvalue[6]
$mvalue[6]="";//Homeconst
// Call MaxPlaceofresidence() Function Here if available in class or required and Load in $mvalue[7]
$mvalue[7]="";//Placeofresidence
// Call MaxBasic() Function Here if available in class or required and Load in $mvalue[8]
$mvalue[8]="";//Basic
// Call MaxScale() Function Here if available in class or required and Load in $mvalue[9]
$mvalue[9]="-1";//Scale
// Call MaxGradepay() Function Here if available in class or required and Load in $mvalue[10]
$mvalue[10]="";//Gradepay
// Call MaxPollcategory() Function Here if available in class or required and Load in $mvalue[11]
$mvalue[11]="-1";//Pollcategory
$mvalue[12]="0";
// Call MaxGazeted() Function Here if available in class or required and Load in $mvalue[13]
$mvalue[13]="";//Gazeted
// Call MaxPhone() Function Here if available in class or required and Load in $mvalue[14]
$mvalue[14]="";//Phone
// Call MaxDor() Function Here if available in class or required and Load in $mvalue[15]
$mvalue[15]="";//Dor
// Call MaxRemarks() Function Here if available in class or required and Load in $mvalue[16]
$mvalue[16]="";//Remarks
//Succesfully update hence make an entry in sql log
if ($col>0)
$objUtility->saveSqlLog("Poling",$sql);
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
header( 'Location: Form_poling.php?tag=1');
?>
<a href=Form_poling.php?tag=1>Back</a>
</body>
</html>
