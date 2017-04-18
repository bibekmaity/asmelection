<?php
session_start();
require_once '../class/class.lac.php';
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.final.php';
require_once './class/class.evmgroup.php';
require_once './class/class.BU.php';
require_once './class/class.CU.php';

$objPs=new Psname();
$objCU=new Cu();
$objBU=new Bu();
$objUtility=new Utility();
$objLac=new Lac();
//echo $_SESSION['rowcount'];
$t2= date('H:i:s');
$tt="";

$objEvm=new Evmgroup();

for ($ind=1;$ind<=$_SESSION['rowcount'];$ind++)
{
$oldCode="Old_Code".$ind;
$Code=$_POST[$oldCode];

$Sel="Sel".$ind;
$Clr="Clr".$ind;
$Res="Res".$ind;

if (isset($_POST[$Res]))
$Res=$_POST[$Res];
else
$Res=0;

if (isset($_POST[$Clr])) //Clear Group
{
$sql="update CU set used='N' where Cu_code in(select CU from evmgroup where lac=".$Code.")";
$res1=$objEvm->ExecuteQuery($sql); 
$sql="update BU set used='N' where Bu_code in(select BU from evmgroup where lac=".$Code.")";
$res2=$objEvm->ExecuteQuery($sql); 

$sql="delete from evmgroup where lac=".$Code;
if ($res1 && $res2)
{    
$objEvm->ExecuteQuery($sql);   
$tt=$tt." Cleared Group for LAC-".$Code;
echo $objUtility->AlertNRedirect($tt, "CreateEVMGroup.php?tag=0");
}
}


if (isset($_POST[$Sel])) //Create Main an Reserve Group
{
//$objUtility->saveSqlLog("Temp","LAC=".$Code) ;   

$totrow=$objPs->rowCount("Lac=".$Code);
$totrow=$totrow+round(($totrow*$Res)/100);
//echo $totrow;
//$objUtility->saveSqlLog("Temp","required=".$totrow) ; 

$cuArr=$objCU->getTopId($totrow);
$buArr=$objBU->getTopId($totrow);


$cuInd=0;
$buInd=0;

if (count($cuArr)<count($buArr))
$tcount= count($cuArr);
else
$tcount= count($buArr);


if($tcount<$totrow) //Not Sifficient no of CU and BU
{
//$objUtility->saveSqlLog("Temp","Required-".$totrow." Available-".$tcount." So failed") ;     
$tt=$tt." Deficinecy of CU/BU to form Group for LAC-".$Code.";Required ".$totrow.": Available ".$tcount;
}
else
{
$tt=$tt." Group Formed for LAC-".$Code;     
//$objUtility->saveSqlLog("Temp","CU selected=".$tcount) ; 
$objPs->setCondString("Lac=".$Code." order by PSNO");   
$row=$objPs->getAllRecord();
//$objUtility->saveSqlLog("Temp","PS found=".count($row)) ; 

for ($i=0;$i<count($row);$i++)
{
$objUtility->saveSqlLog("Temp","i=".$i);
$rcode=$row[$i]['Rcode'];  
$j=$objEvm->maxGrpno();
$objEvm->setGrpno($j);
$objEvm->setLac($Code);
$objEvm->setReserve("N");
$objEvm->setRcode($rcode); 
$objEvm->setCu($cuArr[$cuInd]);
$objEvm->setBu($buArr[$buInd]);

if ($objEvm->SaveRecord())
{
$objBU->setBu_code($buArr[$buInd]);
$objBU->setUsed("Y");
$objBU->setRnumber(rand());
$objBU->UpdateRecord();

$objCU->setCu_code($cuArr[$cuInd]);
$objCU->setUsed("Y");
$objCU->setRnumber(rand());
$objCU->UpdateRecord();

$cuInd++;
$buInd++;
}  
$objUtility->saveSqlLog("Temp",$objEvm->returnSql) ; 
$objUtility->saveSqlLog("Temp",$objBU->returnSql) ; 
$objUtility->saveSqlLog("Temp",$objCU->returnSql) ; 
}//for loop Main Group
//Reserve Group
//$objUtility->saveSqlLog("Temp","Reserve") ; 
for ($id=$i;$id<$tcount;$id++)
{
$j=$objEvm->maxGrpno();
$objEvm->setGrpno($j);
$objEvm->setLac($Code);
$objEvm->setReserve("Y");
//$objEvm->setRcode($rcode); 
$objEvm->setCu($cuArr[$cuInd]);
$objEvm->setBu($buArr[$buInd]); 
if ($objEvm->SaveRecord())
{
$objBU->setBu_code($buArr[$buInd]);
$objBU->setUsed("R");
$objBU->setRnumber(rand());
$objBU->UpdateRecord();

$objCU->setCu_code($cuArr[$cuInd]);
$objCU->setUsed("R");
$objCU->setRnumber(rand());
$objCU->UpdateRecord();    
$cuInd++;
$buInd++;
}    
//$objUtility->saveSqlLog("Temp",$objEvm->returnSql) ; 
//$objUtility->saveSqlLog("Temp",$objBU->returnSql) ; 
//$objUtility->saveSqlLog("Temp",$objCU->returnSql) ; 
} // for loop  reserve Selection
} //if tcount<totrow
}//is isset
}//for loop LAC LOOP


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

$_SESSION['msg']=$tt;

//header( 'Location: CreateEVMGroup.php?tag=0&mtype=100');
echo $objUtility->alert($tt);
?>
<a href="CreateEVMGroup.php">Back</a>