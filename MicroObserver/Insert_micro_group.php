<body>
<?//php include("connection.php"); ?>
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.microps.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();
$objUtility=new Utility();
$allowedroll=2; //Change according to Business Logic

$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');

$objMicrops=new Microps();

$a_Grpno=$objMicrops->maxGrpno();
$mvalue[1]=$a_Grpno;
if (!is_numeric($a_Grpno))
$myTag++;

if(isset($_POST['Lac']))
{
$b_Lac=$_POST['Lac'];
$mvalue[0]=$b_Lac;
}
else
header( 'Location: MicroStart.php?tag=0');

if (!is_numeric($b_Lac))
$myTag++;

$d_Adv=array();
$ps=0;
$c_Pslist="";
$k=0;
for($i=1;$i<=10;$i++)
{
$Sel="Sel".$i;
$Adv="Adv".$i;
if(isset($_POST[$Sel]))
{
$c_Pslist=$c_Pslist.$_POST[$Sel].",";
$ps++;
if(isset($_POST[$Adv]))
{    
$d_Adv[$k]= $_POST[$Adv];
$k++;    
}    
}
} //for loop

$noPs=$k;
//Check if All PS are same Reporting date
$tt=$d_Adv[0];
$same="Y";
echo "0-".$tt."<br>";
for($k=1;$k<count($d_Adv);$k++)
{
//echo $k."-".$d_Adv[$k]."<br>";    
if($d_Adv[$k]!=$tt)
{
$same="N";   
//echo "next".$k."-".$d_Adv[$k].$same."<br>";
}
}

if($same=="N")
{
$_SESSION['msg']="Poling Station Are of Different Date";
//header('Location: microstart.php?tag=1');
$_SESSION['mvalue']=$mvalue;
}


$c_Pslist=substr($c_Pslist,0,strlen($c_Pslist)-1);



$objMicrops=new Microps();
$mmode="";

if($same=="Y")
{
if ($myTag==0)
{
$objMicrops=new Microps();
$objMicrops->setGrpno($a_Grpno);
$objMicrops->setLac($b_Lac);
$objMicrops->setPslist($c_Pslist);
$objMicrops->setAdvance($tt);
$objMicrops->setNo_of_ps($noPs);

$result=$objMicrops->SaveRecord();
$mmode=$ps." Poling Station [".$c_Pslist."] Combined into Group No-".$a_Grpno;
$sql=$objMicrops->returnSql;

$_SESSION['msg']=$mmode;
if (!$result)
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Sql Error)<br>".$sql;
}
else
{
//Clear the Required Field back to Entry Form
//$mvalue[0]="";
$mvalue[1]=$objMicrops->maxGrpno();
$mvalue[2]="";
//Succesfully update hence make an entry in sql log
$msql="update psname set Micro_group=".$a_Grpno." where Lac=".$b_Lac." and Psno in(".$c_Pslist.")";
$objMicrops->ExecuteQuery($msql);
$_SESSION['update']=0;
$_SESSION['mvalue']=$mvalue;
} //$result
} 
else//$myTag==0
{
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']="Failed to Update(Data Type Error)<br>".$sql;
}
} //$same=N
header( 'Location: microstart.php?tag=1');
?>
</body>
</html>
