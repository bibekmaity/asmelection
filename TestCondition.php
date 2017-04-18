
<?php
session_start();
require_once './class/utility.class.php';
//require_once './class/class.lac.php';
require_once './class/class.category.php';

require_once './class/class.testgroup.php';
require_once './class/class.poling.php';



//require_once './class/class.final.php';

//RANDOMISATION'


$objPg=new Testgroup();
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

if (isset($_POST['Res']))
$a_Res=$_POST['Res'];
else
$a_Res=0;

$mvalue[0]=$a_Res;

if (isset($_POST['Category']))
$b_Category=$_POST['Category'];
else
$b_Category=0;

$mvalue[1]=$b_Category;

$c_Home_lac=0;
if (isset($_POST['Home_lac']))
$c_Home_lac=1;
$mvalue[2]=$c_Home_lac;

$f_R_lac=0;
if (isset($_POST['R_lac']))  //Residential LAC
$f_R_lac=1;
$mvalue[3]=$f_R_lac;


$d_Dep_lac=0;
if (isset($_POST['Dep_lac']))
$d_Dep_lac=1;
$mvalue[4]=$d_Dep_lac;

$cg=0;
if (isset($_POST['cg']))
$cg=1;
$mvalue[5]=$cg;

$mcond=" and Depcode in(Select Depcode from department where Dep_type in(";
if($cg==1)
$mcond=$mcond."'G',";    


$bp=0;
if (isset($_POST['bp']))
$bp=1;
$mvalue[6]=$bp;
if($bp==1)
$mcond=$mcond."'B',";    
//B C G H M O P  Dep Type

$sg=0;
if (isset($_POST['sg']))
$sg=1;
$mvalue[7]=$sg;

if($sg==1)
$mcond=$mcond."'C','H','M','P','O',"; 

$mcond=$mcond."'-'))";

$status=0;

$randomised=false; //Initislise as not randomised
$objCategory=new Category();
$objCategory->setCode($b_Category);

if ($objCategory->EditRecord())
{
$catg=$objCategory->getName();
if($objCategory->Randomised($b_Category))
{
$msg=$objCategory->getSelected()." ".$catg." Already Selected" ;   
$randomised=true;
$status="N";
}
}
else
{
$catg="";    
}


//echo $catg;
//echo $randomised;

$mCatg=array();

$TestResult=array();
//Clear Preveous Selection    
if ($randomised==false) //Not Yet Randomised
{
$sql="update poling set selected='N' where selected='T' and pollcategory=".$b_Category;
$objPg->ExecuteQuery($sql);

$row=$objPg->getAllRecord();
$tt="";
for ($j=0;$j<count($row);$j++)
{
$a_Lac=$row[$j]['Lacno'];

$mCatg[1]=$row[$j]['Pr'];
$mCatg[2]=$row[$j]['P1'];
$mCatg[3]=$row[$j]['P2'];
$mCatg[4]=$row[$j]['P3'];
$mCatg[5]=$row[$j]['P4'];
$mCatg[7]=$row[$j]['Micro'];

//echo $a_Lac.":".$mCatg[1]."-".$mCatg[5]."<br>";
$tt=$tt."For Lac No-".$a_Lac." ".$catg;

$cond=" sex='M' and selected='N' and deleted='N' and  grpno=0 and pollcategory=".$b_Category;

if ($c_Home_lac==1)
$cond=$cond." and homeconst<>".$a_Lac ;

if ($d_Dep_lac==1)
$cond=$cond." and depconst<>".$a_Lac ;


if ($f_R_lac==1)
$cond=$cond." and R_lac<>".$a_Lac ;

$cond=$cond.$mcond;

$cond=$cond." order by tag desc,rnumber";

//echo $cond."<br>";

$objPoling->setCondString($cond);
$myrow=$objPoling->getTopSerial($cond,$mCatg[$b_Category]); //Select TOP toal Required Row on Condition

$success=$success+count($myrow);
$TestResult[$j]['Lac']=$a_Lac;
$TestResult[$j]['Required']=$mCatg[$b_Category];
$TestResult[$j]['Found']=count($myrow);

//USE SINGLE QUERY
$sql="update poling set Selected='T' where ".$cond." limit ".$mCatg[$b_Category];
$objPoling->ExecuteQuery($sql);
$tt=$sql;
} //for LOOP for LAC  $j

//$_SESSION['success']=$success;
//$_SESSION['TestResult']=$TestResult;
} //if $found=false;


$_SESSION['category']=$catg;
$_SESSION['mvalue']=$mvalue;

//update the condition
$objCategory->setCode($b_Category);
$objCategory->setAllow_home_lac($c_Home_lac);
$objCategory->setAllow_dep_lac($d_Dep_lac);
$objCategory->setAllow_res_lac($f_R_lac);
$objCategory->UpdateRecord();

//Display Result Sheet
$testresult="<table border=1 width=100% align=center>";
$testresult=$testresult."<tr><td colspan=3 align=center width=100% bgcolor=#66FF99>Result of Test for ".$catg."</td></tr>";

$testresult=$testresult."<tr><td align=center><font face=arial size=2>LAC NO</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>Required</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>Found</td></tr>";
$des=0;
$tot1=0;
$tot2=0;
for($index=0;$index<count($TestResult);$index++)
{
$testresult=$testresult."<tr><td align=center><font face=arial size=2>".$TestResult[$index]['Lac']."</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>".$TestResult[$index]['Required']."</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>".$TestResult[$index]['Found']."</td></tr>";
$des=$des+($TestResult[$index]['Required']-$TestResult[$index]['Found']);
$tot1=$tot1+$TestResult[$index]['Required'];
$tot2=$tot2+$TestResult[$index]['Found'];
}
//Total Row
$testresult=$testresult."<tr><td align=right width=40% bgcolor=#66FF99>Total</td>";
$testresult=$testresult."<td align=center bgcolor=#66FF99><font face=arial size=2><b>".$tot1."</td>";
$testresult=$testresult."<td align=center bgcolor=#66FF99><font face=arial size=2><b>".$tot2."</td></tr>";
$testresult=$testresult."</table>";

if($des>0)
{
$msg="Discrepency of ".$des." ".$catg.",So First Level Randomisation Could not been Completed. Either Enter More Person or uncheck some condition and Retest";
$status="N";
}
if($tot2>0 && $des==0)
{
$msg="Suceess! You may Finalise this selection now";
$status="Y";
}
echo $msg."&".$testresult;
?>
<input type=hidden name="Mixed" id="Mixed" value="Y" size=1 disabled>
<input type=hidden name="Tested" id="Tested" value="<?php echo $status;?>" size=1 disabled>        