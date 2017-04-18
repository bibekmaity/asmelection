
<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.psname.php';
require_once './class/class.polinggroup.php';
require_once './class/class.poling.php';
require_once './class/class.training.php';
require_once './class/class.sentence.php';
require_once './class/class.status.php';
require_once './class/class.final.php';

//RANDOMISATION'

$objPg=new Polinggroup();
$objPoling=new Poling();
$objUtility=new Utility();


$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');



$t2= date('H:i:s');
//echo "start-".$t2;

$success=0;
$fail=0;
//drop and Create Primary key for SLNO
//mysql_query("Alter table poling drop primary key");
//mysql_query("Alter table poling add primary key (rslno)");
if (isset($_POST['Lac']))
$a_Lac=$_POST['Lac'];
else
$a_Lac=0;

$mvalue[0]=$a_Lac;

if (isset($_POST['Category']))
$b_Category=$_POST['Category'];
else
$b_Category=0;

$mvalue[1]=$b_Category;

$c_Home_lac=0;
if (isset($_POST['Home_lac']))
$c_Home_lac=1;
$mvalue[2]=$c_Home_lac;

$d_Dep_lac=0;
if (isset($_POST['Dep_lac']))
$d_Dep_lac=1;
$mvalue[3]=$d_Dep_lac;

$e_Sameoffice=0;
if (isset($_POST['Sameoffice']))
$e_Sameoffice=1;
$mvalue[4]=$e_Sameoffice;

$f_R_lac=0;
if (isset($_POST['R_lac']))  //Residential LAC
$f_R_lac=1;
$mvalue[5]=$f_R_lac;


$maxtrg=0;

$trgcond=" and slno in(select poling_id from poling_training where  (";    

if (isset($_POST['TrgAny'])) //Consider OR Condition for Training Attendance
$AndOr=" or ";
else
$AndOr=" and ";



if (isset($_POST['Trg1']))
{
$trgcond=$trgcond." Attended1='Y'";  
$maxtrg++;
}    


if (isset($_POST['Trg2'])) //Check 2nd day training
{
if ($maxtrg>0)
$trgcond=$trgcond.$AndOr;
//$trgcond=$trgcond." and ";    
$trgcond=$trgcond." Attended2='Y'";  
$maxtrg++;
}  

if (isset($_POST['Trg3'])) //check third day training
{
if ($maxtrg>0)
$trgcond=$trgcond.$AndOr;
//$trgcond=$trgcond." and ";    
$trgcond=$trgcond." Attended3='Y'";  
$maxtrg++;
} 
if($maxtrg>0)
$trgcond=$trgcond.") and Phaseno=1"; 


$trgcond=$trgcond.")";


//NEW CODE  11 JULY
if ($b_Category==1)
{
$condition=" Lac=".$a_Lac." and Prno=0";    
$total=$objPg->rowCount($condition);  //Total Officer required  
$cond=" sex='M' and selected='Y' and deleted='N' and  grpno=0 and pollcategory=1 ";

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
//$objPoling->setCondString($cond);
//$myrow=$objPoling->getSelectedRow($total); //Select TOP toal Required Row on Condition
//if (count($myrow)<$total)
//$fail=$total-count($myrow);
//else //Update Poling Table as wel as Poling Group Table
//{

$objPg->setCondString("Prno=0 and lac=".$a_Lac." order by grpno") ;   
$row=$objPg->getmyGrpNo();
for ($j=0;$j<count($row);$j++)
{
$objUtility->UserPresent();
$objPoling->setCondString($cond);
$myrow=$objPoling->getTopRow();
if (count($myrow)==0)
$fail++;
else
{
$grp=$row[$j];
$objPg->setGrpno($grp);
$objPg->setPrno($myrow['Slno']);
$objPg->setDcode($myrow['Depcode']);
if ($objPg->UpdateRecord())
{
//$objUtility->saveSqlLog ("PickPoling", $objPg->returnSql);
$rnum=rand(100000,150000);
$sql="update poling set Grpno=".$grp.", rnumber=".$rnum." where Slno=".$myrow['Slno'];
if($objPg->ExecuteQuery($sql))
{    
$success++;
//$objUtility->saveSqlLog ("PickPoling", $sql);
} //$objPg->Execute
} //$objPg->UpdateRecord
} //if count($myrow)==0
}//for ($j=0    
} //$b_Category=1
//END NEW CODE 11 JULY


if ($b_Category>1) //All Poling Officer
{
if ($b_Category==2) //first poling
$cond="po1no=0 and lac=".$a_Lac." order by grpno";

if ($b_Category==3) //Second poling
$cond="po2no=0 and lac=".$a_Lac." order by grpno";

if ($b_Category==4) //Third poling
$cond="po3no=0 and lac=".$a_Lac." order by grpno";

if ($b_Category==5) //forth poling
$cond=" large=true and po4no=0 and lac=".$a_Lac." order by grpno";


$objPg->setCondString($cond) ;   

$row=$objPg->getAllRecord();
//Set Common Condition
$Ccond=" ";
if ($c_Home_lac==1)
$Ccond=$Ccond." and homeconst<>".$a_Lac ;

if ($d_Dep_lac==1)
$Ccond=$Ccond." and depconst<>".$a_Lac ;

if ($f_R_lac==1)
$Ccond=$Ccond." and R_lac<>".$a_Lac ;

if ($maxtrg>0)
$Ccond=$Ccond.$trgcond;


for ($j=0;$j<count($row);$j++)
{
//$t= date('H:i:s');
//$objUtility->saveSqlLog("Time1", $j.".".$t);
//$objUtility->UserPresent();      
$grp=$row[$j]['Grpno'];
$dcode=$row[$j]['Dcode'];
$dcode1=$row[$j]['Dcode1'];
$dcode2=$row[$j]['Dcode2'];
$dcode3=$row[$j]['Dcode3'];
//$dcode4=$row[$j]['Dcode4'];

$cond=" sex='M' and selected='Y' and deleted='N' and  grpno=0 and pollcategory=".$b_Category;

$cond=$cond.$Ccond;
if ($e_Sameoffice==1) //different Office
{
$cond=$cond." and ";    
if ($b_Category==2) //ist
$cond=$cond." depcode<>".$dcode;
if ($b_Category==3) //2nd
$cond=$cond." depcode<>".$dcode." and depcode<>".$dcode1;
if ($b_Category==4) //3rd
$cond=$cond." depcode<>".$dcode." and depcode<>".$dcode1." and depcode<>".$dcode2;
if ($b_Category==5) //3rd
$cond=$cond." depcode<>".$dcode." and depcode<>".$dcode1." and depcode<>".$dcode2." and depcode<>".$dcode3;
}
//Add Training Condition


$cond=$cond." order by tag desc,rnumber";

//echo $cond;

$objPoling->setCondString($cond);
$myrow=$objPoling->getTopRow();
//$objUtility->saveSqlLog("pGroup", $objPoling->returnSql);
if (count($myrow)==0)
{    
$fail++;
//$objUtility->saveSqlLog("pGroup","--Failed");
}
else
{
$objPg->setGrpno($grp);
if ($b_Category==2) //ist
{    
$objPg->setPo1no($myrow['Slno']);
$objPg->setDcode1($myrow['Depcode']);
}
if ($b_Category==3) //ist
{    
$objPg->setPo2no($myrow['Slno']);
$objPg->setDcode2($myrow['Depcode']);
}
if ($b_Category==4) //3rd
{    
$objPg->setPo3no($myrow['Slno']);
$objPg->setDcode3($myrow['Depcode']);
}
if ($b_Category==5) //4th
{    
$objPg->setPo4no($myrow['Slno']);
$objPg->setDcode4($myrow['Depcode']);
}
if ($objPg->UpdateRecord())
{ 
//$objUtility->saveSqlLog ("PickPoling", $objPg->returnSql);
$rnum=rand(100000,150000);    
$sql="update poling set grpno=".$grp.",rnumber=".$rnum." where Slno=".$myrow['Slno'];
if($objPg->ExecuteQuery($sql))
{    
$success++;
//$objUtility->saveSqlLog ("PickPoling", $sql);
} //$objPg->Execute
}  //updaterecord  
} //count myrow=0 
?>
<script language="javascript">
<?php //echo "window.setTimeout(".chr(34)."window.status=".chr(34).$j.chr(34).", 1000);"; 
</script>       
<?php
} //for loop
} //  $b_Category>1

$objCategory=new Category();
$objCategory->setCode($b_Category);
$objCategory->EditRecord();
$catg=$objCategory->getName();

$tt="";
$mvalue[1]=$objPg->PresentCategory($mvalue[0]);
$_SESSION['mvalue']=$mvalue;
if ($success>0)
$tt=$tt."Selected ".$success." ".$catg;
if ($fail>0)
$tt=$tt.":Failed to Select ".$fail." ".$catg." with Selected Condition(Either Relax some Condition or Update Database)";
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
//echo "result=".$success."-".$fail."<br>";
//echo $mvalue[0]." ".$mvalue[1];
header( 'Location: SelectPoling.php?tag=1&mtype=100');


//echo "End time".$t1."<br>";
//echo "Time-".$objUtility->elapsedTime($t1, $t2);
//echo "<br>Thank U";
?><a href="SelectPoling.php?tag=1&mtype=100"
</body></html>
