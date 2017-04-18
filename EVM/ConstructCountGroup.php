
<?php
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.lac.php';
require_once '../class/class.category.php';
//require_once './class/class.psname.php';
require_once '../class/class.Microgroup.php';
require_once '../class/class.poling.php';
//require_once '../class/class.training.php';
//require_once '../class/class.sentence.php';
//require_once '../class/class.status.php';
//require_once '../class/class.final.php';
require_once '../class/class.countinghall.php';
require_once '../class/class.countinggroup.php';


$objCh=new Countinghall();
$objMg=new Countinggroup();


$objPoling=new Poling();
$objUtility=new Utility();

$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');

$tbl="MTAB";

$t2= date('H:i:s');
//echo "start-".$t2;

$success=0;
$fail=0;


if (isset($_POST['Lac']))
$a_Lac=$_POST['Lac'];
else
$a_Lac=0;
$mvalue[0]=$a_Lac;

if (isset($_POST['Res']))
$Res=$_POST['Res'];
else
$Res=0;
$mvalue[1]=$Res; //Micro Observer

if (isset($_POST['Ast']))
$Ast=$_POST['Ast'];
else
$Ast=0;
$mvalue[2]=$Ast; //Micro Observer

if (isset($_POST['So']))
$So=1;
else
$So=0;

$mvalue[3]=$So; 

$b_Category=7;





//NEW CODE  11 JULY

$condition[0]="  Lac=".$a_Lac;  

$rcount=0;


$sql="update poling set countgrpno=0,countselected='N' where countgrpno in(select grpno from countinggroup where Lac=".$a_Lac.")";
echo $sql."<br>";
if($objMg->ExecuteQuery($sql))
$objMg->ExecuteQuery("delete from Countinggroup where Lac=".$a_Lac);


$objCh->setCondString("Lac=".$a_Lac);
$objMg->setLac($a_Lac);
$row=$objCh->getAllRecord();
$rcount=0;
for($i=0;$i<count($row);$i++) //Hall Loop
{
$hall=$row[$i]['Hall'];
$objMg->setHall_no($hall);
$start=$row[$i]['Start_table'];
$tot=$row[$i]['No_of_table'];    
 
for($k=$start;$k<$start+$tot;$k++) //Table Loop
{
$str=$objMg->maxGrpno();    
$objMg->setGrpno($str);    
$objMg->setTable_no($k); 
$objMg->setReserve("N"); 
if($objMg->SaveRecord())
$rcount++;
} //$k=0
} //$i=0

//reserve Person
$extra=round(($rcount*$Res)/100);  //Count reserve
if ($extra<1 && $Res>0)
$extra=1;

for($m=0;$m<$extra;$m++)
{
$str=$objMg->maxGrpno();    
$objMg->setGrpno($str);      
$objMg->setHall_no("0");  
$objMg->setTable_no("0"); 
$objMg->setReserve("N"); 
if($objMg->SaveRecord())
$rcount++;
}
//END Reserve

//echo $total."+".$extra."<br>";
//$objUtility->saveSqlLog($tbl, $objPs->returnSql);    

//Supervisor
$mcat=1;
$tot=$So+2;

$fld=array();
$fld[1]="Sr";
$fld[2]="Ast1";
$fld[3]="Static_observer";

for($mcat=1;$mcat<=$tot;$mcat++)
{
$cond=" sex='M' and deleted='N' and Countgrpno=0 and Countselected='N' and countcategory=".$mcat;
$cond=$cond." order by tag desc,rnumber";
//retrive Necessary  $total Row from Poling table 
$objPoling->setCondString($cond);
$myrow=$objPoling->getSelectedRow($rcount); //Select TOP toal Required Row on Condition

if (count($myrow)<$rcount)
$fail=$rcount-count($myrow);
else //Update Poling Table as wel as Poling Group Table
{
$objMg->setCondString($fld[$mcat]."=0 and lac=".$a_Lac." order by grpno") ;   
$row=$objMg->getAllRecord();
//$objUtility->saveSqlLog($tbl, $objMg->returnSql);    
for ($j=0;$j<count($row);$j++)
{
$grp=$row[$j]['Grpno'];
$msql="update countinggroup set ".$fld[$mcat]."=".$myrow[$j]['Slno']." where Grpno=".$grp;
if ($objMg->ExecuteQuery($msql))
{
//$objUtility->saveSqlLog($tbl, $objMg->returnSql);    
//$objUtility->saveSqlLog("Grp", $objPg->returnSql);
$rnum=rand(1,5000);
$sql="update poling set CountSelected='Y',CountGrpno=".$grp.", rnumber=".$rnum." where Slno=".$myrow[$j]['Slno'];
//$objUtility->saveSqlLog("Grp", $sql);
if($objMg->ExecuteQuery($sql))
$success++;
} //$objMg->UpdateRecord
}//for ($j=0   
} //else count($myrow)<$rcount)
} //for LOOP $mcat

$tt="";
$t1= date('H:i:s');

$tt=$tt.$objUtility->elapsedTimeMsg($t1, $t2);


$_SESSION['msg']="Completed in ".$tt;

//echo "result=".$success."-".$fail."<br>";
//echo $mvalue[0]." ".$mvalue[1];
header( 'Location: startcountgroup.php?tag=1&mtype=100');

//echo "End time".$t1."<br>";
//echo "Time-".$objUtility->elapsedTime($t1, $t2);
//echo "<br>Thank U";
?>
<a href="startcountgroup.php?tag=0&mtype=100"
</body></html>
