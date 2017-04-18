<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.hpc.php';
require_once '../class/class.party_calldate.php';
//Rows per Page
if (isset($_GET['mrows']))
$mrows=$_GET['mrows'];
else
$mrows=15;

// Rows Height
//if (isset($_GET['rheight']))
//$rheight=$_GET['rheight'];
//else
$rheight=50;

if(isset($_POST['mpdf']))
$mpdf=true;
else
$mpdf=false;

$objUtility=new Utility();
$objPsname=new Psname();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

//$util=new myutility();
$cwidth=array();
$cwidth[0]="35%";
$cwidth[1]="65%";


$ddosign=<<<EOD
<p align="center">
<b>SIGNATURE OF CELL INCHARGE</b>
</p>
EOD;


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 11);
$pdf->setPrintFooter(false);
$tblfdata="";

if(isset($_POST['Code']))
$laccode=$_POST['Code'];
else
$laccode=0;
if(isset($_POST['rtag']))
$rtag=$_POST['rtag'];
else
$rtag=-1;    


$objLac=new Lac();
$objLac->setCode($laccode);
if($objLac->EditRecord())
{
$lacname=strtoupper($objLac->getName());
$hpcode=$objLac->getHpccode();
}
else
{
$lacname="";
$hpcode=0;
}

$objHpc=new Hpc();
$objHpc->setHpccode($hpcode);
if($objHpc->EditRecord())
$hpname=$objHpc->getHpcname ();
else
$hpname="";    

$objTp=new Party_calldate();
$objTp->setCode($rtag);
if($objTp->EditRecord())
$date1=$objTp->getMydate ();
else
$date1="";


$objPsname=new Psname();
//$cond=" Lac=".$laccode." and REPORTING_TAG=".$rtag." order by rcode";
if(isset($_POST['from']))
$a1=$_POST['from'];
else
$a1=0;

if(isset($_POST['to']))
$a2=$_POST['to'];
else
$a2=0;
echo $a1.".".$a2;
$cond="lac=".$laccode." and Rcode>='".$a1."' and Rcode<='".$a2."' and REPORTING_TAG=".$rtag." order by rcode";


$totrec=$objPsname->rowCount($cond);
$objUtility=new Utility();
$cspan=7;

//echo $totrec;

$blankrow=<<<EOD
<tr>
<td align="LEFT" colspan="2">&nbsp;</td>
</tr>
<tr>
EOD;


$rowcount=0;
$colvalue=array();
//Initialise Total Variable


$objPsname->setCondString($cond);
$row=$objPsname->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$rowcount++;
$colvalue[0]=$row[$ii]['Rcode'];
$colvalue[1]=$row[$ii]['Part_no'];
$colvalue[2]=$row[$ii]['Psname']."<br>".$row[$ii]['Address'];
$colvalue[3]=$row[$ii]['Male'];
$colvalue[4]=$row[$ii]['Female'];
$VOTER=$colvalue[3]+$colvalue[4];

$tbldata=<<<EOD
<table cellpadding="3" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;">
<tr>
<td align="center" colspan="2" width="100%"><b><U>DECODING SLIP FOR PRESIDING OFFICER</u></b>
</td>
</tr>
$blankrow$blankrow
<tr>
<td align="LEFT" width="$cwidth[0]">GROUP CODE</td>
<td align="LEFT" width="$cwidth[1]"><b>$colvalue[0]</b></td>
</tr>
$blankrow

<tr>
<td align="LEFT" width="$cwidth[0]">NO & NAME OF HPC</td>
<td align="LEFT" width="$cwidth[1]">$hpcode-$hpname</td>
</tr>
$blankrow
<tr>
<td align="LEFT" width="$cwidth[0]">NO & NAME OF LAC</td>
<td align="LEFT" width="$cwidth[1]">$laccode-$lacname</td>
</tr>
$blankrow
<tr>
<td align="LEFT" width="$cwidth[0]">POLING STATION NO</td>
<td align="LEFT" width="$cwidth[1]">$colvalue[1]</td>
</tr>
$blankrow
<tr>
<td align="LEFT" width="$cwidth[0]">POLING STATION NAME</td>
<td align="LEFT" width="$cwidth[1]">$colvalue[2]</td>
</tr>
$blankrow
<tr>
<td align="LEFT" width="$cwidth[0]">TOTAL VOTER</td>
<td align="LEFT" width="$cwidth[1]">$VOTER</td>
</tr>
$blankrow
</table>
EOD;


if($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->writeHTML($tbldata.$ddosign, true, false, false, false, '');
}
else
echo $tbldata;

} //for loop



if($mpdf==true)
{
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}


?>
