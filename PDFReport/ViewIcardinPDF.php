<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.poling.php';
require_once '../class/class.category.php';
require_once '../class/class.polinggroup.php';
require_once '../class/class.Training_phase.php';
require_once '../class/class.Sentence.php';
require_once '../class/class.party_calldate.php';


//Rows per Page
if (isset($_GET['mrows']))
$mrows=$_GET['mrows'];
else
$mrows=3;

$objSen=new sentence();

// Rows Height
if (isset($_GET['rheight']))
$rheight=$_GET['rheight'];
else
$rheight=48;

$mpdf=true;
//$mpdf=false;


$objUtility=new Utility();
$objPoling=new Poling();
$objPg=new Polinggroup();
$objCat=new category();


$objTp=new Training_phase();
$objTp->setPhase_no("1");
if($objTp->EditRecord())
{
$district=strtoupper($objTp->getElection_district ());
$sign=strtoupper($objTp->getSignature());
}
else
{
$district="[MYDISTRICT]";
$sign="[MYSIGNATURE]";
}

$deo=$objSen->SentenceCase($sign)."<br>".$objSen->SentenceCase($district);


//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

//$util=new myutility();
$cwidth=array();
$cwidth[0]="30%";
$cwidth[1]="45%";
$cwidth[2]="25%";


if(isset($_POST['Code']))
$laccode=$_POST['Code'];
else 
$laccode=0;


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 8);
$pdf->setPrintFooter(false);
$tblfdata="";
$objPoling=new Poling();

if(isset($_POST['from']))
$a1=$_POST['from']-1000;
else
$a1=0;

if(isset($_POST['to']))
$a2=$_POST['to']-1000;
else
$a2=0;


$cond=" Grpno between ".$a1." and ".$a2." and Selected='Y' and Grpno in(Select Grpno from polinggroup where  Lac=".$laccode.") order by Grpno,Pollcategory";
$totrec=$objPoling->rowCount($cond);

$blanktable=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr><td width="100%" heifht="50"><br><br><br>PHOTO<br><br><br></td></tr>
</table>
EOD;


$rowcount=0;
$colvalue=array();
//Initialise Total Variable
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
//Seting Page group

$slno=0;
$pagecount=0;
$lastpage="";
$i=1;
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;
$Slno=$row[$ii]['Slno'];
$name=$row[$ii]['Name'];
$desig=$row[$ii]['Desig'];
$duty="Presiding";
$rcode=$row[$ii]['Grpno']+1000;
$Code="G-".$row[$ii]['Grpno'];

$objCat->setCode($row[$ii]['Pollcategory']);
if ($objCat->EditRecord())
$duty=$objCat->getName ();
else
$duty="";

$tbldata=<<<EOD
<table cellpadding="2" width="60%" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr><td width="100%">
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;">
<tr><td align="left" width="50%"><b>Parliamentary Election-2014</b></td>
<td align="right" width="45%">Group Code-<b>$rcode</b></td>
</tr>
<tr>
<td align="center" colspan="3" width="100%">
<img src="../image/ashoka.jpg" width="30" height="40">
</td>
</tr>
<tr>
<td align="center" colspan="3" width="100%">
GOVT OF ASSAM<BR>
OFFICE OF THE $sign:::$district
</td>
</tr>

<tr>
<td align="center" width="35%">
</td>
<td align="center" width="30%" bgcolor="grey">
IDENTITY CARD
</td>
<td align="center" width="35%">
</td>
</tr>
<tr>
<td align="center" colspan="2" width="75%">&nbsp;</td>
<td align="center" width="$cwidth[2]" rowspan="6">$blanktable</td>
</tr>
<tr><td align="left" width="$cwidth[0]">Name of Officer</td>
<td align="left" width="$cwidth[1]"><b>$name</b></td>
</tr>
<tr><td align="left" width="$cwidth[0]">Official Designation</td>
<td align="left" width="$cwidth[1]">$desig</td>
</tr>
<tr><td align="left" width="$cwidth[0]">Election Designation</td>
<td align="left" width="$cwidth[1]">$duty</td>
</tr>
<tr><td align="left" width="$cwidth[0]">Poling ID</td>
<td align="left" width="$cwidth[1]">$Slno</td>
</tr>
<tr>
<td align="center" colspan="3" width="100%">
<br><br>
</td>
</tr>
<tr><td align="left" width="45%">Signature of Card Holder</td>
<td align="center" width="10%">&nbsp;</td>
<td align="center" width="45%">$deo</td>
</tr>
</table>
</td></tr></table>
<BR><BR><BR>
EOD;


$tblfdata=$tblfdata.$tbldata;
if ($rowcount==3 || ($ii+1)==$totrec)
{
if($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->writeHTML($tblfdata, true, false, false, false, '');
}
else
echo $tblfdata;
$tblfdata="";
$rowcount=0;
} //if rowcount
}//for loop

if($mpdf==true)
{
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}


?>
