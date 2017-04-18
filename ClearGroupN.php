<html>
<head><title>Assigning Random Number</title></head>
<script language=javascript>
<!--

function home()
{
  window.location="randmenu.php";  
}
</script>
<BODY>
    
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
require_once './class/class.Polinggroup.php';
require_once './class/utility.class.php';
require_once './class/class.psname.php';
require_once './class/class.Lac.php';
//require_once './class/class.Poling.php';

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

if($objUtility->validate($res)==false)
header('location:Cleargroup.php?tag=0') ;

if(isset($_POST['Lac']))
$mvalue[1]=$_POST['Lac'];
else
$mvalue[1]=0;    


$laccode=$mvalue[1];

$t2= date('H:i:s');
  

$objTest=new Polinggroup();
$sql="UPDATE PSNAME SET Forthpoling_required=1 WHERE MALE+FEMALE>1199 and Lac=".$mvalue[1];

$objTest->ExecuteQuery($sql);
$sql="UPDATE PSNAME SET Forthpoling_required=0 WHERE MALE+FEMALE<1200 and Lac=".$mvalue[1];
$objTest->ExecuteQuery($sql);
$sql="UPDATE PSNAME SET RCODE='0000' WHERE  Lac=".$mvalue[1];
$objTest->ExecuteQuery($sql);

//$sql="update poling set selected='N' where selected='T' ";
//$objTest->ExecuteQuery($sql);

$cond=array();
$cond[0]="  and Reporting_tag=0 and Forthpoling_required=0";    
$cond[1]="  and Reporting_tag=0 and Forthpoling_required=1";    
$cond[2]="  and Reporting_tag=1 and Forthpoling_required=0";    
$cond[3]="  and Reporting_tag=1 and Forthpoling_required=1";    


//  ($laccode);
$objTest->setLac($laccode);
$grpno=$objTest->maxGrpno();
$objPs=new Psname();
for ($jj=0;$jj<4;$jj++) //condition loop within PS
{

$str=" Lac=".$laccode.$cond[$jj];   
$objPs->setCondString($str);
$psrow=$objPs->getAllRecord();
//For Normal Group
for($k=0;$k<count($psrow);$k++)
{
$objUtility->UserPresent();
$rcode=1000+$grpno;    
$large=$psrow[$k]['Forthpoling_required'];
$adv=$psrow[$k]['Reporting_tag'];
$objTest->setGrpno($grpno);
$objTest->setRcode($rcode);  
$objTest->setLarge($large);
$objTest->setReserve("N");
$objTest->setAdvance($adv);
if($objTest->SaveRecord())
$myvar=0;    
//$objUtility->saveSqlLog ("RandomiseFirstStep", $objTest->returnSql);
$grpno++;
//$objUtility->saveSqlLog("Grp", $objTest->returnSql);
} 
//psname loop
//For Reserve Group
if(count($psrow)>0)
{  
//$objUtility->UserPresent();  
$extra=round(($k*$res)/100);
if($extra<1)
$extra=1;
}
else
$extra=0;

//echo $jj.".".$k."*".$res."=".$extra."<br>";

for($m=0;$m<$extra;$m++)
{
//$objUtility->UserPresent();
$rcode=1000+$grpno;    
$objTest->setGrpno($grpno);
$objTest->setRcode($rcode);  
$objTest->setLarge($large);
$objTest->setReserve("N");
$objTest->setAdvance($adv);
///$objTest->setPrno($extra);
if($objTest->SaveRecord())
$myvar=0;    
//$objUtility->saveSqlLog ("RandomiseFirstStep", $objTest->returnSql);
$grpno++;
}//for m=0
} //condition loop

 
$tt="(Query Took ";
$t1= date('H:i:s');
$mrow=$objUtility->elapsedTime($t1, $t2);
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Minutes ";
if ($mrow['s']>=0)
$tt= $tt.$mrow['s']." Second";
$tt= $tt.")";
echo $objUtility->alert($tt);

//$_SESSION['mvalue']=$mvalue;
$_SESSION['msg']=$tt;
header('Location:ClearGroup.php?tag=1');
?>
    <a href="ClearGroup.php?tag=1">Back</a>

</body></html>
