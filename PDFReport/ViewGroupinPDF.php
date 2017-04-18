<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.polinggroup.php';
require_once '../class/class.poling.php';
require_once '../class/class.lac.php';
require_once '../class/class.hpc.php';
require_once '../class/class.party_calldate.php';
$objPt=new Party_calldate();
$objPolinggroup=new Polinggroup();


$objPt->setCode("1");
if ($objPt->EditRecord())
$deo=$objPt->getMsignature ();
else
$deo="Signature"   ;

$objUtility=new Utility();
$objLac=new Lac();
$objPoling=new Poling();
$objHpc=new Hpc();
$objS=new Sentence();


$objPolinggroup=new Polinggroup();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=2;  //Rows per Page
$rheight=48; // Rows Height

if(isset($_GET['code']))
$laccode=$_GET['code'];
else 
$laccode=0;

if(isset($_POST['From']))
$from=$_POST['From'];
else
$from=0;    

if(isset($_POST['To']))
$to=$_POST['To'];
else
$to=0; 

$GroupList=$objPolinggroup->getGroup($laccode,$from,$to);

if($from==0 && $to==0)
$grpcount=$objPolinggroup->rowCount("Lac=".$laccode);
else
$grpcount=$to-$from+1;    

if(isset($_POST['mpdf']))
$mpdf=true;
else
$mpdf=false;

if(!is_numeric($laccode))
$laccode=0;

if($laccode==0)
header('location:Selectpoling.php?tag=0');    
    
$objLac->setCode($laccode);
if ($objLac->EditRecord())
{    
$lacname=strtoupper($objLac->getName ()); 
$hpccode=$objLac->getHpccode();
$objHpc->setHpccode($hpccode);
if ($objHpc->EditRecord())
$hpcname=strtoupper($objHpc->getHpcname());
else
$hpcname=""; 
}
else
header( 'Location: ViewGroup.php');

//echo $laccode;
//echo $lacname;
    
    
$cwidth=array();
$cwidth[0]="7%";
$cwidth[1]="37%";
$cwidth[2]="14%";
$cwidth[3]="14%";
$cwidth[4]="14%";
$cwidth[5]="14%";

$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 8);
$pdf->setPrintFooter(false);


if($from==0 && $to==0)
$totrec=$objPolinggroup->rowCount("lac=".$laccode);
else
$totrec=$from-$to+1;

$objUtility=new Utility();
$cspan=9;
$title=<<<EOD

EOD;

//echo $totrec;

$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan="6"   align="center">
POLING GROUP FOR <b>$laccode-$lacname</b>&nbsp;LAC
UNDER HPC-<b>$hpccode-$hpcname</b>
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]" bgcolor="white"><b>Sl No</b></td>
<td align="center" width="$cwidth[1]" bgcolor="white"><b>Name of Officer</b></td>
<td align="center" width="$cwidth[2]" bgcolor="white"><b>Category</b></td>
<td align="center" width="$cwidth[3]" bgcolor="white"><b>Home LAC</b></td>
<td align="center" width="$cwidth[4]" bgcolor="white"><b>Residential LAC</b></td>
<td align="center" width="$cwidth[5]" bgcolor="white"><b>Working LAC</b></td>
</tr>

EOD;
$tblbottom=<<<EOD
</table>
EOD;
$ddosign=<<<EOD
<p align="center">
<b>$deo</b>
</p>
EOD;
$rowcount=0;
$colvalue=array();
//Initialise Total Variable


//Select Grpno from Polinggroup where Lac=".$laccode


$i=1;
$tblfdata="";
$cond="Grpno in (".$GroupList.")";

$tot=$objPoling->rowCount($cond);
$rowcount=0;
$objPoling->setCondString($cond." order by Grpno,Pollcategory");
//$objPoling->setCondString("Slno<100");
$row=$objPoling->getAllRecord();

//echo count($row);
//echo $objPoling->returnSql;
$prevgrp=0;
$rgrp=0;
$sl=0;

//echo count($row);

//echo "groupciunt".$grpcount."<br>";

for($ii=0;$ii<count($row);$ii++)
//for($ii=0;$ii<20;$ii++)
{
$rowcount++;
$grpno=$row[$ii]['Grpno'];
$objUtility->UserPresent(); //Update Attendence for User

if($prevgrp!=$grpno)
{
$sl++;
$grpcount--;
}
$rspan=$objPoling->rowCount("Grpno=".$grpno);

if(isset($row[$ii+1]['Grpno']))
$nextgrp=$row[$ii+1]['Grpno'];
else
$nextgrp=0;

$rcode=$grpno+1000;

$head=<<<EOD
<tr>
<td align="center" width="100%" colspan=6 bgcolor="white">GROUP CODE-<b>$rcode</b></td>
</tr>
EOD;

$colvalue[0]=($ii+1);

$colvalue[1]="<b>".$row[$ii]['Name']."</b>, ".$row[$ii]['Desig'];
$colvalue[1]=$colvalue[1]."<br>".$row[$ii]['Department'];
$colvalue[1]=$colvalue[1]."<br>Poling Id-".$row[$ii]['Slno'];
$cat=$objUtility->CategoryList[$row[$ii]['Pollcategory']];
$colvalue[2]=$objUtility->LacList[$row[$ii]['Homeconst']];
$colvalue[3]=$objUtility->LacList[$row[$ii]['R_lac']];
$colvalue[4]=$objUtility->LacList[$row[$ii]['Depconst']];

if($row[$ii]['Pollcategory']==1)
{
$frow=<<<EOD
<td align="center" rowspan="$rspan" width="$cwidth[0]"><br><br><br><br><br>$sl</td>
EOD;
}
else
$frow="";

$tbldata=<<<EOD
<tr>
$frow
<td align="left"  width="$cwidth[1]" height="$rheight">$colvalue[1]</td>
<td align="left"  width="$cwidth[2]">$cat</td>
<td align="center"  width="$cwidth[3]">$colvalue[2]</td>
<td align="center"  width="$cwidth[4]">$colvalue[3]</td>
<td align="center"  width="$cwidth[5]">$colvalue[4]</td>
</tr>
EOD;

if($prevgrp!=$grpno)
{
$tblfdata=$tblfdata.$head.$tbldata;
$rgrp++;
}
else
{
$tblfdata=$tblfdata.$tbldata;
}
//if ($rgrp==4 && $grpno!=$nextgrp)
if (($rgrp==4 && $grpno!=$nextgrp) || ($grpcount==0 && $grpno!=$nextgrp) )
{
$tblfdata=$tblhead.$tblfdata.$tblbottom ;
if($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->writeHTML($tblfdata, true, false, false, false, '');
}
else
echo $tblfdata;   
$rgrp=0;
$tblfdata="";
}//if
$prevgrp=$grpno;
} //for LOOP


if($mpdf==true)
{
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
  

?>
