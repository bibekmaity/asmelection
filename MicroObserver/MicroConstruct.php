
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
require_once '../class/class.Microps.php';
//RANDOMISATION'

$objMg=new Microgroup();
$objPoling=new Poling();
$objUtility=new Utility();
$objPs=new Microps();

$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

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


$b_Category=7;


$c_Home_lac=0;
if (isset($_POST['Home_lac']))
$c_Home_lac=1;
$mvalue[2]=$c_Home_lac;

$d_Dep_lac=0;
if (isset($_POST['Dep_lac']))
$d_Dep_lac=1;
$mvalue[3]=$d_Dep_lac;


$f_R_lac=0;
if (isset($_POST['R_lac']))  //Residential LAC
$f_R_lac=1;
$mvalue[5]=$f_R_lac;


$maxtrg=0;

$trgcond=" and slno in(select poling_id from poling_training where ";    

if (isset($_POST['Trg1']))
{
$trgcond=$trgcond." Attended1='Y'";  
$maxtrg++;
}    

$trgcond=$trgcond.")";


//NEW CODE  11 JULY
if ($b_Category==7)
{
$condition[0]=" Advance=0 and Lac=".$a_Lac;  
$condition[1]=" Advance=1 and Lac=".$a_Lac;  

$rcount=0;

$objMg->ExecuteQuery("delete from Microgroup where Lac=".$a_Lac);

$objMg->setLac($a_Lac);
//$objPs->getGrpno()
for($ii=0;$ii<2;$ii++)
{
$objPs->setCondString($condition[$ii]) ; 
$row=$objPs->getAllRecord();
$total=count($row);
$extra=round(($total*$Res)/100);  //Count reserve
if ($extra<1 && $Res>0)
$extra=1;

//echo $total."+".$extra."<br>";
$objUtility->saveSqlLog($tbl, $objPs->returnSql);    
for($i=0;$i<count($row);$i++)
{
$adv=$row[$i]['Advance']; 
$grp=$objMg->maxGrpno();
$objMg->setGrpno($grp);
$objMg->setAdvance($adv);
$objMg->setRnumber("1");
$objMg->SaveRecord();
$rcount++;
//$objUtility->saveSqlLog($tbl, $objMg->returnSql);    
}//for loop $i=0
//Reserve Group

for($k=0;$k<$extra;$k++)
{
$grp=$objMg->maxGrpno();
$objMg->setGrpno($grp);
$objMg->setAdvance($adv);
$objMg->setRnumber("0");
$objMg->SaveRecord();
$rcount++;
//$objUtility->saveSqlLog($tbl, $objMg->returnSql);    
}//for loop $k=0
} //for loop $ii=0

$cond=" sex='M' and selected='Y' and deleted='N' and  grpno=0 and pollcategory=".$b_Category;
//$cond=" 1=1 ";
//echo $cond;

if ($c_Home_lac==1)
$cond=$cond." and homeconst<>".$a_Lac ;

if ($d_Dep_lac==1)
$cond=$cond." and depconst<>".$a_Lac ;


if ($f_R_lac==1)
$cond=$cond." and R_lac<>".$a_Lac ;

if ($maxtrg>0)
$cond=$cond.$trgcond;

$cond=$cond." order by tag desc,rnumber";

//retrive Necessary  $total Row from Poling table 
$objPoling->setCondString($cond);
$myrow=$objPoling->getSelectedRow($rcount); //Select TOP toal Required Row on Condition

//$objUtility->saveSqlLog($tbl, $objPoling->returnSql);    
 

if (count($myrow)<$rcount)
$fail=$rcount-count($myrow);
else //Update Poling Table as wel as Poling Group Table
{
$objMg->setCondString("Micro_id=0 and lac=".$a_Lac." order by grpno") ;   
$row=$objMg->getAllRecord();

$objUtility->saveSqlLog($tbl, $objMg->returnSql);    

for ($j=0;$j<count($row);$j++)
{
$grp=$row[$j]['Grpno'];
$msql="update microgroup set Micro_id=".$myrow[$j]['Slno']." where Grpno=".$grp;
if ($objMg->ExecuteQuery($msql))
{
//$objUtility->saveSqlLog($tbl, $objMg->returnSql);    
//$objUtility->saveSqlLog("Grp", $objPg->returnSql);
$rnum=rand(100000,150000);
$sql="update poling set Grpno=".$grp.", rnumber=".$rnum." where Slno=".$myrow[$j]['Slno'];
//$objUtility->saveSqlLog("Grp", $sql);
if($objMg->ExecuteQuery($sql))
$success++;
} //$objMg->UpdateRecord
}//for ($j=0    
} //
//Now Add Extra Reseerve Person
} //$b_Category=7
//END NEW CODE 11 JULY


$objCategory=new Category();
$objCategory->setCode($b_Category);
$objCategory->EditRecord();
$catg=$objCategory->getName();

$tt="";

$_SESSION['mvalue']=$mvalue;
if ($success>0)
$tt=$tt."Selected ".$success." ".$catg." Officer ";
if ($fail>0)
$tt=$tt.":Failed to Select ".$fail." ".$catg." Officer with this condition";
$t1= date('H:i:s');

$tt=$tt.$objUtility->elapsedTimeMsg($t1, $t2);


$_SESSION['msg']=$tt;

//echo "result=".$success."-".$fail."<br>";
//echo $mvalue[0]." ".$mvalue[1];
header( 'Location: MicroSelect.php?tag=1&mtype=100');


//echo "End time".$t1."<br>";
//echo "Time-".$objUtility->elapsedTime($t1, $t2);
//echo "<br>Thank U";
?><a href="MicroSelect.php?tag=1&mtype=100"
</body></html>
