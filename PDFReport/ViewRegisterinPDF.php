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

if(isset($_POST['mpdf']))
$mpdf=true;
else
$mpdf=false;


$objUtility=new Utility();

$objLac=new Lac();
$objPoling=new Poling();
$objHpc=new Hpc();
$objS=new Sentence();
$objPolinggroup=new Polinggroup();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

//$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=2;  //Rows per Page
$rheight=70; // Rows Height
if(isset($_POST['Code']))
$laccode=$_POST['Code'];
else 
$laccode=0;

$objLac->setCode($laccode);
if ($objLac->EditRecord())
{    
$lacname=$objLac->getName (); 
$hpccode=$objLac->getHpccode();
$objHpc->setHpccode($hpccode);
if ($objHpc->EditRecord())
$hpcname=$objHpc->getHpcname();
else
$hpcname=""; 
}
else
//header( 'Location: ViewGroup.php');

    
    
$cwidth=array();
$cwidth[0]="15%"; //Group Code
$cwidth[1]="45%"; //Name of Officer
$cwidth[2]="15%"; //Duty
$cwidth[3]="25%"; //Remarks



$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 9);
$pdf->setPrintFooter(false);
$tblfdata="";

$objPolinggroup=new Polinggroup();

if(isset($_POST['from']))
$a1=$_POST['from'];
else
$a1=0;

if(isset($_POST['to']))
$a2=$_POST['to'];
else
$a2=0;

$objPolinggroup->setCondString("lac=".$laccode." and Rcode>='".$a1."' and Rcode<='".$a2."'");
$totrec=$objPolinggroup->rowCount("lac=".$laccode." and Rcode>='".$a1."' and Rcode<='".$a2."'");

$objUtility=new Utility();
$cspan=8;
$title=<<<EOD
&nbsp;
EOD;
$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan="4"  height="20"  align="center">
REGISTER FOR POLING GROUP FOR <b>$laccode-$lacname</b>&nbsp;LAC
under HPC-<b>$hpccode-$hpcname</b>
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">Group Code & Call Date</td>
<td align="center" width="$cwidth[1]">Name of Officer</td>
<td align="center" width="$cwidth[2]">Poling Duty</td>
<td align="center" width="$cwidth[3]">Remarks</td>
</tr>

EOD;
$tblbottom=<<<EOD
</table>
EOD;
$ddosign=<<<EOD
<p align="center">
<b>Signature of DDO</b>
</p>
EOD;
$rowcount=0;
$colvalue=array();
//Initialise Total Variable
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
$tot5=0;


$objPoling=new Poling();
$objCat=new Category();
//$str=" Selected='Y' and Grpno>0 and Grpno in(Select Grpno from Polinggroup where Lac=".$laccode.") order by Grpno,Pollcategory";
//$objPoling->setCondString($str);
$row=$objPolinggroup->getAllRecord();
$lastgrp=0;
$tblfdata="";

$trow=array();

$totrecord=count($row);
$rcount=0;
$mpage=0;
for($ii=0;$ii<count($row);$ii++)
{
$objUtility->UserPresent();

//Presiding
$rcount++;
    
$objPt->setCode($row[$ii]['Advance']); //Advance means code which refer to party call date
if ($objPt->EditRecord())
{
$rdate=$objPt->getMydate ();
$pdate=$objPt->getPolldate();
$d2=$objUtility->to_mysqldate($rdate);
$d1=$objUtility->to_mysqldate($pdate);
$totdays=$objUtility->dateDiff($d1, $d2)+1;
}
else
{
$rdate=""   ;    
$totdays=0;
}
$grtot=0;
    
if ($row[$ii]['Prno']>0)  
{
$grtot++; 
$trow[0]=$row[$ii]['Prno'];
}
else
$trow[0]=0;

if ($row[$ii]['Po1no']>0)
{
$grtot++;     
$trow[1]=$row[$ii]['Po1no']; 
}
else
$trow[1]=0;  

if ($row[$ii]['Po2no']>0) 
{
$grtot++; 
$trow[2]=$row[$ii]['Po2no'];
}
else
$trow[2]=0;

if ($row[$ii]['Po3no']>0)
{
$grtot++;     
$trow[3]=$row[$ii]['Po3no'];
}
else
$trow[3]=0;

if ($row[$ii]['Po4no']>0)  
{
$grtot++; 
$trow[4]=$row[$ii]['Po4no'];
}
else
$trow[4]=0;    

//$tblfdata="";

$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
$tot5=0;
for ($j=1;$j<=$grtot;$j++)
{
$objCat->setCode($j);
if($objCat->EditRecord())
{
$cat=$objCat->getName();   
}
else
{
$cat="";
}

$colvalue[0]=$row[$ii]['Rcode'];
$colvalue[1]=$objPoling->PolingDetail4APP($trow[$j-1], 0);

if ($j==1)
{    
$frow=<<<EOD
<td align="center" rowspan="$grtot" height="$rheight" width="$cwidth[0]"><br><br><b>$colvalue[0]</b><br><br><br>$rdate</td>
EOD;
}
else
$frow="";
$tbldata=<<<EOD
<tr>
$frow
<td align="left" height="$rheight" width="$cwidth[1]">$colvalue[1]</td>
<td align="center" height="$rheight" width="$cwidth[2]">$cat</td>
<td align="center" height="$rheight" width="$cwidth[3]">&nbsp;</td>
</tr>
EOD;
$tblfdata=$tblfdata.$tbldata;
}//for loolp for J++
//
//Write a group in HTML
$grossrow=<<<EOD
&nbsp;
EOD;

if ($rcount==2 || ($ii+1)==$totrecord)
{
$mpage++;

$page=<<<EOD
Page-$mpage    
EOD;

if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);
$tblfdata=$tblhead.$tblfdata.$grossrow.$tblbottom.$page;
$pdf->writeHTML($tblfdata, true, false, false, false, '');
$tblfdata="";
}
else
{
$tblfdata=$tblhead.$tblfdata.$grossrow.$tblbottom ;
echo $tblfdata;
$tblfdata="";
}    
$rcount=0;
}

//$lastgrp=$curgrp;
} //for loop


$tblfoot="";
//$tblfoot=$tblfoot.$lastpage;
if($mpdf==true)
{
$pdf->writeHTML($tblfoot, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $tblfdata;

?>
