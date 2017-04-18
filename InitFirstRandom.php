   
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once './class/class.testgroup.php';
require_once './class/utility.class.php';
require_once './class/class.psname.php';
require_once './class/class.Lac.php';
require_once './class/class.Poling.php';
require_once './class/class.microps.php';

$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

if(isset($_POST['Res']))
$res=$_POST['Res'];
else
$res=0;
$mvalue[0]=$res;

if(isset($_POST['Category']))
$mvalue[1]=$_POST['Category'];
else
$mvalue[1]=0;    

$t2= date('H:i:s');
//Randomise Poling Station Table
$objPs=new Psname();
//$objPs->setCondString(" 1=1 ORDER BY Lac,Forthpoling_required,Reporting_tag");
//$row=$objPs->getAllRecord();   
//$k = 1001;
//for($i=0;$i<count($row);$i++)
//{
//$objPs->setLac($row[$i]['Lac']);
//$objPs->setPsno($row[$i]['Psno']);
//$objPs->setRcode($k);
 
//$objPs->UpdateRecord();    
//$k++;
//echo $objPs->returnSql;
//}


$sql="UPDATE PSNAME SET RCODE='0000',Forthpoling_required=1 WHERE MALE+FEMALE>1199";
$objPs->ExecuteQuery($sql);
$sql="UPDATE PSNAME SET RCODE='0000',Forthpoling_required=0 WHERE MALE+FEMALE<1200";
$objPs->ExecuteQuery($sql);
//end PS Randomisation   
if (isset($_SESSION['TestResult']))
unset($_SESSION['TestResult']);

$objTest=new Testgroup();
$sql="update poling set selected='N',Grpno=0 where Pollcategory in(Select Code from Category where Firstrandom='N')";
$objTest->ExecuteQuery($sql);


$cond=array();
$cond[0]=" and Forthpoling_required=0 and Reporting_tag=0";    
$cond[1]=" and Forthpoling_required=0 and Reporting_tag=1";    
$cond[2]=" and Forthpoling_required=1 and Reporting_tag=0";    
$cond[3]=" and Forthpoling_required=1 and Reporting_tag=1";    


$objMicrops=new Microps();


$grpno=0;
$objLac=new Lac();
$str=" Code>0 and Code in(Select distinct Lac from psname)";
$objLac->setCondString($str);
$lacrow=$objLac->getAllRecord();
for($i=0;$i<count($lacrow);$i++)
{
$laccode=$lacrow[$i]['Code'];
$pr=0;
$p4=0;    
$micro=0;
//$objUtility->saveSqlLog("TEst",$p4);

$objTest->setLacno($laccode);
for ($jj=0;$jj<4;$jj++) //condition loop within PS
{
$str=" Lac=".$laccode.$cond[$jj];   
$objPs->setCondString($str);
$psrow=$objPs->getAllRecord();
//For Normal Group
for($k=0;$k<count($psrow);$k++)
{
$pr++;    
if ($psrow[$k]['Forthpoling_required']==1)
$p4++;    
} //psname loop
//$objUtility->saveSqlLog("TEst",$p4);
//For Reserve Group

if (count($psrow)>0)
{
$extra=round(($k*$res)/100);
if($extra<1)
$extra=1;
}
else
$extra=0;

$k=$k-1;
for($m=0;$m<$extra;$m++)
{
$pr++;    
if ($psrow[$k]['Forthpoling_required']==1)
$p4++;
}//for m=0
//$objUtility->saveSqlLog("TEst",$p4);
} //condition loop

//Calculate Requirement for Micro Observer
$mycond="Lac=".$laccode;
$micro=$objMicrops->rowCount($mycond);
if ($micro>0)
{
$extra=round(($micro*$res)/100);
if($extra<1)
$extra=1;
}
else
$extra=0;
$micro=$micro+$extra;

$objTest->setPr($pr);
$objTest->setP1($pr);
$objTest->setP2($pr);
$objTest->setP3($pr);
$objTest->setP4($p4);
if($micro>0)
$objTest->setMicro($micro);
else
$objTest->setMicro("0");
$objTest->SaveRecord();
//$objUtility->saveSqlLog("TEst",$objTest->returnSql);
}//LAC Loop

//Randomise Poling Person
if (isset($_POST['first']))
{
$objP=new Poling();
$cond="   (Rnumber=0 or Rnumber is NULL) and Deleted='N' and Sex='M' and Pollcategory in (1,2,3,4,5,7) order by Pollcategory,Rnumber";
$row=$objP->getAllSerial($cond);
$k=0;
for($i=0;$i<count($row);$i++)
{
//if($i%2==0)  //only Even Serial Number
//{
$str=rand(1,50000);
$sql="update poling set rnumber=".$str." where Slno=".$row[$i];
if($objP->ExecuteQuery($sql))
$k++;
//} //$i%2
} //for Loop
$tt=" Done(Query took ";
$objP->ExecuteQuery("update status set randomised=randomised+1");
} //isset(first)
else
$tt="(Query took ";    
        
    

$t1= date('H:i:s');
$mrow=$objUtility->elapsedTime($t1, $t2);
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Minutes ";
if ($mrow['s']>=0)
$tt= $tt.$mrow['s']." Second";
$tt= $tt.")";
//echo $objUtility->alert($tt);
echo $tt."&"."Mixing Done";
$_SESSION['mvalue']=$mvalue;
$_SESSION['timetaken']=$tt;
//header('Location:FirstLevel.php?tag=1');
?>
<input type=hidden name="Mixed" id="Mixed" value="Y" size=1 disabled>


