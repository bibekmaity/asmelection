<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.training.php';
require_once './class/class.training_phase.php';
require_once './class/class.trg_venue.php';
require_once './class/class.trg_hall.php';
require_once './class/class.trg_time.php';
require_once './class/class.poling_history.php';
require_once './class/class.poling_training.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$a="";
$b="";
$c="";
$objUtility=new Utility();


//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify



$objTraining=new Training();
$objTv=new Trg_venue();

unset($_SESSION['phase']);

$Err="<font face=arial size=1 color=blue>";
$a_Phaseno=1;

if(isset($_POST['Noday']))
$mvalue[0]=$_POST['Noday'];
else
$mvalue[0]=0; 



$b_Groupno=$objTraining->maxGroupno(1);
$mvalue[1]=$b_Groupno;

if (!is_numeric($b_Groupno))
$myTag++;


if(isset($_POST['Trgdate1']))
{
$c_Trgdate1=$_POST['Trgdate1'];
$mvalue[2]=$c_Trgdate1;
if ($objUtility->validate($c_Trgdate1)==true)
{
$a="Y";    
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($c_Trgdate1)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-3";
}

if (strlen($c_Trgdate1)==0)
{
$c_Trgdate1="NULL";
$a="";
}
}
else
$myTag++;
}
else
{
$c_Trgdate1="NULL";
$mvalue[2]="";
}


if(isset($_POST['Trgdate2']))
{
$d_Trgdate2=$_POST['Trgdate2'];
$mvalue[3]=$d_Trgdate2;
if ($objUtility->validate($d_Trgdate2)==true)
{
$b="Y";
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($d_Trgdate2)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-4";
}

if (strlen($d_Trgdate2)==0)
{
$d_Trgdate2="NULL";
$b="";
}
}
else
$myTag++;
}
else
{
$d_Trgdate2="NULL";
$mvalue[3]="";
}


if(isset($_POST['Trgdate3']))
{
$e_Trgdate3=$_POST['Trgdate3'];
$mvalue[4]=$e_Trgdate3;
if ($objUtility->validate($e_Trgdate3)==true)
{
$c="Y";    
//Unicode Shouldnot Exist
if ($objUtility->isUnicodeCharExist($e_Trgdate3)==true)
{
$myTag++;
$Err=$Err." Expect NonUnicode in Field-5";
}

if (strlen($e_Trgdate3)==0)
{
$e_Trgdate3="NULL";
$c=""; 
}
}
else
$myTag++;
}
else
{
$e_Trgdate3="NULL";
$mvalue[4]="";
}


$f_Venue_code=$_POST['Venue_code'];
$mvalue[5]=$f_Venue_code;
if (is_numeric($f_Venue_code)==false)
{
$f_Venue_code="NULL";
}
$g_Hall_rsl=$_POST['HallNumber'];
$mvalue[6]=$g_Hall_rsl;
if (is_numeric($g_Hall_rsl)==false)
{
$g_Hall_rsl="NULL";
}
$h_Trgtime=$_POST['Trgtime'];
$mvalue[7]=$h_Trgtime;
if (!is_numeric($h_Trgtime))
$myTag++;
$j_Hallcapacity=$_POST['Hallcapacity'];
$mvalue[8]=$j_Hallcapacity;
if (is_numeric($j_Hallcapacity)==false)
{
$j_Hallcapacity="NULL";
}
$m_Pr=$_POST['Pr'];
$mvalue[9]=$m_Pr;
if (!is_numeric($m_Pr))
$myTag++;
$n_P1=$_POST['P1'];
$mvalue[10]=$n_P1;
if (!is_numeric($n_P1))
$myTag++;
$o_P2=$_POST['P2'];
$mvalue[11]=$o_P2;
if (!is_numeric($o_P2))
$myTag++;
$p_P3=$_POST['P3'];
$mvalue[12]=$p_P3;
if (!is_numeric($p_P3))
$myTag++;
$q_P4=$_POST['P4'];
$mvalue[13]=$q_P4;
if (!is_numeric($q_P4))
$myTag++;


$mmode="";
if ($myTag==0)
{
$objTraining->setPhaseno($a_Phaseno);
$objTraining->setGroupno($b_Groupno);
$objTraining->setTrgdate1($c_Trgdate1);

if ($mvalue[0]==2)
{    
$objTraining->setTrgdate2($d_Trgdate2);
}
if ($mvalue[0]==3)
{    
$objTraining->setTrgdate2($d_Trgdate2);
$objTraining->setTrgdate3($e_Trgdate3);
}

$objTraining->setVenue_code($f_Venue_code);

$objTv->setVenue_code($f_Venue_code);
if ($objTv->EditRecord())
$objTraining->setTrgplace ($objTv->getVenue_name ());    

$objTraining->setHall_rsl($g_Hall_rsl);
$objTraining->setTrgtime($h_Trgtime);
$j_Hallcapacity=$m_Pr+$n_P1+$o_P2+$p_P3+$q_P4;
$objTraining->setHallcapacity($j_Hallcapacity);
//$objTraining->setPr($m_Pr);
//$objTraining->setP1($n_P1);
//$objTraining->setP2($o_P2);
//$objTraining->setP3($p_P3);
//$objTraining->setP4($q_P4);
$t2= date('H:i:s');
if ($_SESSION['update']==0)
{
if ($objTraining->DuplicateExist()==false)
{
$result=$objTraining->SaveRecord();
$mmode="Group Created Successfully! ";
$sql=$objTraining->returnSql;
$col=1;
if ($result)
{
$objUtility->saveSqlLog("Training",$sql);
$objUtility->Backup2Access("", $sql);  
$objTp=new Poling_training();
$mmode=$mmode.$objTp->SelectTrainee($a_Phaseno, $b_Groupno, $m_Pr, $n_P1, $o_P2, $p_P3, $q_P4,$a,$b,$c);

$tt=$tt."(Query took ";
$t1= date('H:i:s');
$mrow=$objUtility->elapsedTime($t1, $t2);
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Minutes ";
if ($mrow['s']>0)
$tt= $tt.$mrow['s']." Second";
$tt= $tt.")";
$mmode=$mmode.$tt;
}
}
else
{
$result=true;
$mmode="Duplicate Data";
$col=0;    
} //duplicateexist  

}//sesion_update
else 
{
$result=$objTraining->UpdateRecord();
$col=$objTraining->colUpdated;
if ($col>0)
$mmode=$col." Column Updated";
else
$mmode="Nothing to Update";
$sql=$objTraining->returnSql;
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
// Call MaxPhaseno() Function Here if available in class or required and Load in $mvalue[0]
//$mvalue[0]="";//Phaseno
// Call MaxGroupno() Function Here if available in class or required and Load in $mvalue[1]
//$mvalue[1]="";//Groupno
// Call MaxTrgdate1() Function Here if available in class or required and Load in $mvalue[2]
//$mvalue[2]="";//Trgdate1
// Call MaxTrgdate2() Function Here if available in class or required and Load in $mvalue[3]
//$mvalue[3]="";//Trgdate2
// Call MaxTrgdate3() Function Here if available in class or required and Load in $mvalue[4]
//$mvalue[4]="";//Trgdate3
// Call MaxVenue_code() Function Here if available in class or required and Load in $mvalue[5]
//$mvalue[5]="";//Venue_code
// Call MaxHall_rsl() Function Here if available in class or required and Load in $mvalue[6]
if($mmode!="Duplicate Data")
{
$mvalue[6]="";//Hall_rsl
$mvalue[8]="";//Hallcapacity
$mvalue[9]="0";
$mvalue[10]="0";
$mvalue[11]="0";
$mvalue[12]="0";
$mvalue[13]="0";  
}

// Call MaxTrgtime() Function Here if available in class or required and Load in $mvalue[7]
//$mvalue[7]="";//Trgtime
// Call MaxHallcapacity() Function Here if available in class or required and Load in $mvalue[8]


//Succesfully update hence make an entry in sql log
if ($col>0)
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$Err;
}
header( 'Location: Form_training.php?tag=1&mtype=100');
?>
<a href=Form_training.php?tag=1>Back</a>
</body>
</html>
