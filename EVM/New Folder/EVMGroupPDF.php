<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once './class/class.evmgroup.php';
require_once './class/class.cu.php';
require_once './class/class.bu.php';
require_once '../class/class.lac.php';
require_once '../class/class.party_calldate.php';
$objPt=new Party_calldate();

$objPt->setCode("1");
if ($objPt->EditRecord())
$deo=$objPt->getMsignature ();
else
$deo="Signature"   ;

$objUtility=new Utility();
$objEvmgroup=new Evmgroup();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

//$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=40;  //Rows per Page
$rheight=22; // Rows Height
//$util=new myutility();
$cwidth=array();
$cwidth[0]="10%";
$cwidth[1]="35%";
$cwidth[2]="35%";
$cwidth[3]="20%";

if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

if (!is_numeric($code))
$code=0;

$objLac=new Lac();
$objLac->setCode($code);
if ($objLac->EditRecord())
$lacname=$code."-".strtoupper($objLac->getName());
else
$lacname=""; 
//echo $lacname;

$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$mpdf=true;
//$mpdf=false;

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 12);
$pdf->setPrintFooter(false);
$tblfdata="";
$objEvmgroup=new Evmgroup();

$objEvmgroup->setCondString("lac=".$code);
$totrec=$objEvmgroup->rowCount("lac=".$code);

//echo "record-".$totrec;
$objUtility=new Utility();
$objLac=new Lac();

$cspan=6;

$title=<<<EOD
&nbsp;
EOD;
$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  align="center">
<br>EVM PAIR FOR $lacname
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]" rowspan="2">Pair No</td>
<td align="center" width="$cwidth[1]" colspan="2">Control Unit</td>
<td align="center" width="$cwidth[2]" colspan="2">Ballot Unit</td>
<td align="center" width="$cwidth[3]" rowspan="2">Remarks</td>
</tr>
<tr>
<td align="center" width="15%">Trunc No</td>
<td align="center" width="20%">Unit No</td>
<td align="center" width="15%">Trunc No</td>
<td align="center" width="20%">Unit No</td>
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
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
//Seting Page group
$pgroup=array();
$tot=$totrec;
$i=1;
while ($tot>$mrows)
{
$pgroup[$i]=$mrows;
$tot=$tot-$mrows;
$i++;
}
$pgroup[$i]=$tot;
$slno=0;
$pagecount=0;
$lastpage="";
$i=1;
$row=$objEvmgroup->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;
$colvalue[0]=$ii+1;
$objCu=new Cu();
$objCu->setCu_code($row[$ii]['Cu']);
$objCu->EditRecord();
$tvalue=$objCu->getCu_number();
$colvalue[1]=$tvalue;
$cutr=$objCu->getTrunck_number();
$objBu=new Bu();
$objBu->setBu_code($row[$ii]['Bu']);
$objBu->EditRecord();
$tvalue=$objBu->getBu_number();
$colvalue[2]=$tvalue;
$butr=$objBu->getTrunck_number();
if ($row[$ii]['Reserve']=="Y")
$colvalue[3]="Used for Reserve";
else
$colvalue[3]="&nbsp;";  
$tbldata=<<<EOD
<tr>
<td align="center" width="$cwidth[0]">$slno</td>
<td align="center" width="15%">$cutr</td>
<td align="center" height="$rheight" width="20%">$colvalue[1]</td>
<td align="center" width="15%">$butr</td>
<td align="center" height="$rheight" width="20%">$colvalue[2]</td>
<td align="center" height="$rheight" width="$cwidth[3]">$colvalue[3]</td>
</tr>
EOD;
$tblfdata=$tblfdata.$tbldata;
if ($rowcount>=$pgroup[$i])
{
$i++;
$pagecount++;
$mpage=<<<EOD
<p align="right">Page-$pagecount</p>
EOD;
$mpage=$mpage;
if ($slno==$totrec)
{
$lastpage=$mpage;  //store last page number in a variable so that it can be used after last rows
$mpage="&nbsp;";
}
$tblfdata=$tblhead.$tblfdata.$tblbottom.$mpage ;
if ($slno<$totrec)
$tblfdata=$tblfdata;
if($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
if ($i==2)//For First Page
$pdf->writeHTML($title, true, false, false, false, '');
$pdf->writeHTML($tblfdata, true, false, false, false, '');
}
else
echo $tblfdata;
$tblfdata="";
$rowcount=0;
} //if rowcount
} //for loop

$cspan=1;
$tblfoot=<<<EOD
&nbsp;
EOD;
$tblfoot=$tblfoot.$lastpage.$ddosign;
if($mpdf==true)
{
$pdf->writeHTML($tblfoot, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $tblfoot;

?>
