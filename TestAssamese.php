<body>
<?php
session_start();
require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');
header("Content-Type: text/html; charset=utf-8");
mysql_query("SET NAMES UTF8");



$mpdf=true;
//$mpdf=false;

$PageFormat="A4";  //8.5x11

//$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('vrinda', '', 14);
$pdf->setPrintFooter(false);


$tbldata=<<<EOD
দিপক গোস্বামী <br> 
দেবজিত চৌধুৰী <br>    
জয়ন্ত কুমাৰ ডেকা <br>  
ৰাহুল ডেকা 
EOD;



if($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->writeHTML($tbldata, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $tbldata;
?>
