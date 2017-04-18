
<?php
session_start();
require_once './class/utility.class.php';

require_once './class/class.testgroup.php';
require_once './class/class.Category.php';

//require_once './class/class.final.php';

//RANDOMISATION'


$objPg=new Testgroup();
$objCat=new Category();


if (isset($_SESSION['TestResult']))
unset($_SESSION['TestResult']);

if(isset($_SESSION['msg']))
unset($_SESSION['msg']);
if (isset($_SESSION['category']))
unset($_SESSION['category']);

if(isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);

if(isset($_SESSION['success']))
unset($_SESSION['success']);



$objUtility=new Utility();

if (isset($_SESSION['TestResult']))
unset($_SESSION['TestResult']);

$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

$mvalue=array();

$t2= date('H:i:s');

if (isset($_POST['Res']))
$mvalue[0]= $_POST['Res'];
else
$mvalue[0]=0;    
    
if (isset($_POST['Category']))
$b_Category=$_POST['Category'];
else
$b_Category=0;

$mvalue[1]=$b_Category;

$offcat=$objUtility->CategoryList[$b_Category];

$rc=$objPg->SumCategory($b_Category);

$sql="update Poling set grpno=0,selected='Y' where Selected='T' and Pollcategory=".$b_Category;

if ($objPg->ExecuteQuery($sql))
{
//$objUtility->saveSqlLog("TT", $sql) ;   
$objCat->setCode($b_Category);
$objCat->setFirstrandom("Y");
$objCat->setSelected($rc);
if ($objCat->UpdateRecord())
$tt= "Finalised ".$objPg->rowCommitted." ".$offcat;
else
$tt="Failed..";
}
//$objUtility->saveSqlLog("TT", $rc) ; 
//$objUtility->saveSqlLog("TT", $objCat->returnSql) ; 
$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']=$tt;
//header( 'Location: FirstLevel.php?tag=3');

$objCat->setCondString(" Selected>0 and FirstRandom='Y' order by Code");
$row=$objCat->getAllRecord();
$n=count($row);
if ($n>0)
{
$testresult="<table border=1 width=100% align=center>";
$testresult=$testresult."<tr><td colspan=2 align=center width=100% bgcolor=#66FF99>First Level Randomisation Detail</td></tr>";

$testresult=$testresult."<tr><td align=center bgcolor=#66FF99><font face=arial size=2>Category</td>";
$testresult=$testresult."<td align=center bgcolor=#66FF99><font face=arial size=2>Selected</td></tr>";

for($j=0;$j<$n;$j++)
{
$name=$row[$j]['Name'];
$tot=$row[$j]['Selected'];
$testresult=$testresult."<tr><td align=center><font face=arial size=2>".$name."</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>".$tot."</td></tr>";
} //$j==0
$testresult=$testresult."</table>";
} //$n>0

echo $tt."&".$testresult;
?>
<input type=hidden name="Mixed" id="Mixed" value="Y" size=1 disabled>
<input type=hidden name="Tested" id="Tested" value="N" size=1 disabled>        
