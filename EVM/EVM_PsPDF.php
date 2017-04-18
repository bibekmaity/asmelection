<body>
<?php
session_start();
require_once('../..//tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once './class/class.evmgroup.php';
require_once '../class/class.psname.php';
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


$objPS=new Psname();
$objCU=new Cu();
$objBU=new Bu();

//Rows per Page
if (isset($_GET['mrows']))
$mrows=$_GET['mrows'];
else
$mrows=25;

if (isset($_GET['code']))
$code=$_GET['code'];
else
$code=0;

$objLac=new Lac();
$objLac->setCode($code);
if($objLac->EditRecord())
$lacname=$objLac->getName();
else
$lacname="";


// Rows Height
if (isset($_GET['rheight']))
$rheight=$_GET['rheight'];
else
$rheight=30;

if (isset($_GET['mpdf']))
$mpdf=true;
else
$mpdf=false;

$mpdf=true;

$objUtility=new Utility();
$objEvmgroup=new Evmgroup();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

//$util=new myutility();
$cwidth=array();
$cwidth[0]="7%";
$cwidth[1]="10%";
$cwidth[2]="35%";
//$cwidth[3]="9%";
$cwidth[4]="24%";
$cwidth[5]="24%";
$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 9);
$pdf->setPrintFooter(false);
$tblfdata="";
$objEvmgroup=new Evmgroup();
$cond="Lac=".$code." order by Reserve,Psno";

$totrec=$objEvmgroup->rowCount($cond);
$objUtility=new Utility();
$cspan=7;
$title=<<<EOD
&nbsp;
EOD;

$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  align="center">
ALLOCATION OF EVM PAIR TO POLING STATION
<br>NAME OF LAC-<b>$code-$lacname</b>
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]" rowspan="2">SlNo</td>
<td align="center" width="$cwidth[1]" rowspan="2">Ps No.</td>
<td align="center" width="$cwidth[2]" rowspan="2">Poling Station Name</td>
<td align="center" width="$cwidth[4]" colspan="2">Control Unit Detail</td>
<td align="center" width="$cwidth[5]" colspan="2">Ballot Unit Detail</td>
</tr>
<tr>
<td align="center" width="12%">Current ID</td>
<td align="center" width="12%">Unit Number</td>
<td align="center" width="12%">Current ID</td>
<td align="center" width="12%">Unit Number</td>
</tr>
EOD;
$tblbottom=<<<EOD
</table>
EOD;

$ddosign=<<<EOD
<p align="center">
<br><br>
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
$tot5=0;
//Seting Page group
//$pgroup=array();
$tot=$totrec;
$slno=0;
$pagecount=0;
$lastpage="";
$i=1;
$objEvmgroup->setCondString($cond);
$row=$objEvmgroup->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;

$cuid=$row[$ii]['Cu_id'];
$buid=$row[$ii]['Bu_id'];

if($row[$ii]['Psno']>0)
$colvalue[0]=$row[$ii]['Psno'];
else
$colvalue[0]="R";

$objPS->setLac($code);
$objPS->setPsno($colvalue[0]);
if ($objPS->EditRecord())
$colvalue[1]=$objPS->getPsname ();
else
$colvalue[1]="<b>Reserve</b>";
$colvalue[2]=$row[$ii]['Grpno'];
$objCU->setCu_code($row[$ii]['Cu']);
if ($objCU->EditRecord())
$colvalue[3]=$objCU->getCu_number ();
else
$colvalue[3]="";
$objBU->setBu_code($row[$ii]['Bu']);
if ($objBU->EditRecord())
$colvalue[4]=$objBU->getBu_number ();
else
$colvalue[4]="";

$tbldata=<<<EOD
<tr>
<td align="center" width="$cwidth[0]">$slno</td>
<td align="center" height="$rheight" width="$cwidth[1]">$colvalue[0]</td>
<td align="left" height="$rheight" width="$cwidth[2]">$colvalue[1]</td>
<td align="center" width="12%">$cuid</td>
<td align="center" width="12%">$colvalue[3]</td>
<td align="center" width="12%">$buid</td>
<td align="center" width="12%">$colvalue[4]</td>
</tr>
EOD;
$tblfdata=$tblfdata.$tbldata;
if ($rowcount==$mrows || $slno==$totrec)
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
//if ($slno<$totrec)
//$tblfdata=$tblfdata.$ddosign;
if($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
//if ($i==2)//For First Page
//$pdf->writeHTML($title, true, false, false, false, '');
$pdf->writeHTML($tblfdata, true, false, false, false, '');
$pdf->writeHTML($ddosign, true, false, false, false, '');
}
else
echo $tblfdata;
$tblfdata="";
$rowcount=0;
} //if rowcount

} //for loop
$cspan=1;


if($mpdf==true)
{
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $ddosign;

?>
