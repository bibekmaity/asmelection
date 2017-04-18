
<?php
session_start();

require_once './class/class.polinggroup.php';
require_once './class/class.poling.php';
require_once './class/utility.class.php';


$objPg=new Polinggroup();
$objPoling=new Poling();

$objUtility=new Utility();
$success=0;
$fail=0;

if (isset($_POST['Lac']))
$a_Lac=$_POST['Lac'];
else
$a_Lac=0;

$a_Name="";
if($a_Lac>0)
$a_Name=$objUtility->LacList[$a_Lac];

if (isset($_POST['Category']))
$b_Category=$_POST['Category'];
else
$b_Category=0;

if($b_Category>0)
$catg=$objUtility->CategoryList[$b_Category];
else
$catg="";
$c_Home_lac=0;
if (isset($_POST['Home_lac']))
$c_Home_lac=1;


$d_Dep_lac=0;
if (isset($_POST['Dep_lac']))
$d_Dep_lac=1;

$f_R_lac=0;
if (isset($_POST['R_lac']))  //Residential LAC
$f_R_lac=1;

$condition=" Lac=0 and Prno=-1";  //Initialise

if ($b_Category==1)
$condition=" Lac=".$a_Lac." and Prno=0";    

if ($b_Category==2)
$condition=" Lac=".$a_Lac." and Po1no=0"; 

if ($b_Category==3)
$condition=" Lac=".$a_Lac." and Po2no=0"; 

if ($b_Category==4)
$condition=" Lac=".$a_Lac." and Po3no=0"; 

if ($b_Category==5)
$condition=" Lac=".$a_Lac." and Po4no=0 and large=true"; 

if($b_Category>0 && $a_Lac>0)
$totalR=$objPg->rowCount($condition);  //Total Officer required  


$cond=" sex='M' and selected='Y' and deleted='N' and  grpno=0 and pollcategory=".$b_Category;
if ($c_Home_lac==1)
$cond=$cond." and homeconst<>".$a_Lac ;

if ($d_Dep_lac==1)
$cond=$cond." and depconst<>".$a_Lac ;

if ($f_R_lac==1)
$cond=$cond." and R_lac<>".$a_Lac ;

$cond=$cond." and 1=1";

$totalA=$objPoling->rowCount($cond);  //Total Officer Available
if($b_Category>0 && $a_Lac>0)
{
?>
<body>
<font face="arial" size="2" color="black" >   
<?php echo $a_Lac;?>&nbsp;<?php echo $a_Name;?>:&nbsp;Required:&nbsp;<b><?php echo $totalR;?></b>&nbsp;
<?php echo $catg;?>,&nbsp;
Availbale with Selected LAC Condition:&nbsp;<b><?php echo $totalA;?></b>
<?php
}
?>
</font></body></html>
