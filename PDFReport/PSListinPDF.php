<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.party_calldate.php';

//Rows per Page
if (isset($_GET['mrows']))
$mrows=$_GET['mrows'];
else
$mrows=25;

// Rows Height
if (isset($_GET['rheight']))
$rheight=$_GET['rheight'];
else
$rheight=30;

if (isset($_POST['mpdf']))
$mpdf=true;
else
$mpdf=false;

//$mpdf=true;
//$mpdf=false;

$objUtility=new Utility();
$objPsname=new Psname();




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
$objLac->EditRecord();
$lacname=strtoupper($objLac->getName());

$objTp=new Party_calldate();
$objTp->setCode($rtag);
if($objTp->EditRecord())
$date1=$objTp->getMydate ();
else
$date1="";

//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

//$util=new myutility();
$cwidth=array();
$cwidth[0]="10%";// Slno
$cwidth[1]="10%"; //PartNo
$cwidth[2]="40%"; //PSaname and Address
$cwidth[3]="10%"; //Male
$cwidth[4]="10%"; //female
$cwidth[5]="10%"; //Total
$cwidth[6]="10%"; //Sensitivity

$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 9);
$pdf->setPrintFooter(false);
$tblfdata="";
$objPsname=new Psname();
$cond="lac=".$laccode." and Reporting_tag=".$rtag;
$totrec=$objPsname->rowCount($cond);
$objUtility=new Utility();
$cspan=9;
$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan   align="center">
</td>
</tr>
</table>
EOD;
$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  align="center">
<br>Poling Station List of <b>$laccode-$lacname</b>
<br>Reporting Date:$date1    
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">SlNo</td>
<td align="center" width="$cwidth[1]">Part No</td>
<td align="center" width="$cwidth[2]">PS Name and Address</td>
<td align="center" width="$cwidth[3]">Male</td>
<td align="center" width="$cwidth[4]">Female</td>
<td align="center" width="$cwidth[5]">Total</td>
<td align="center" width="$cwidth[6]">Sensitivity</td>

</tr>
<tr>
<td align="center" width="$cwidth[0]">1</td>
<td align="center" width="$cwidth[1]"><I>1</I></td>
<td align="center" width="$cwidth[2]"><I>2</I></td>
<td align="center" width="$cwidth[3]"><I>3</I></td>
<td align="center" width="$cwidth[4]"><I>4</I></td>
<td align="center" width="$cwidth[5]"><I>5</I></td>
<td align="center" width="$cwidth[6]"><I>6</I></td>
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
$tot6=0;
$tot7=0;
$tot8=0;
//Seting Page group
//$pgroup=array();
$tot=$totrec;
$slno=0;
$pagecount=0;
$lastpage="";
$i=1;
$objPsname->setCondString($cond);
$row=$objPsname->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;
$colvalue[0]=$row[$ii]['Part_no'];
$colvalue[1]=$row[$ii]['Psname']."<br>".$row[$ii]['Address'];
$colvalue[2]=$row[$ii]['Male'];
$colvalue[3]=$row[$ii]['Female'];
$colvalue[4]=$row[$ii]['Female']+$row[$ii]['Male'];
$colvalue[5]=$row[$ii]['Sensitivity'];
$tbldata=<<<EOD
<tr>
<td align="center" width="$cwidth[0]">$slno</td>
<td align="Center" height="$rheight" width="$cwidth[1]">$colvalue[0]</td>
<td align="left" height="$rheight" width="$cwidth[2]">$colvalue[1]</td>
<td align="center" height="$rheight" width="$cwidth[3]">$colvalue[2]</td>
<td align="center" height="$rheight" width="$cwidth[4]">$colvalue[3]</td>
<td align="center" height="$rheight" width="$cwidth[5]">$colvalue[4]</td>
<td align="center" height="$rheight" width="$cwidth[6]">$colvalue[5]</td>
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
$tot1=$tot1+$row[$ii]['Male'];
$tot2=$tot2+$row[$ii]['Female'];
$tot3=$tot3+$row[$ii]['Male']+$row[$ii]['Female'];
} //for loop
$cspan=1;
$tblfoot=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=3  align="right" width="60%">Total</td>
<td align="center" width="$cwidth[3]">$tot1</td>
<td align="center" width="$cwidth[4]">$tot2</td>
<td align="center" width="$cwidth[5]">$tot3</td>
<td align="center" width="$cwidth[6]">&nbsp;</td>
</tr>
</table>
EOD;
$tblfoot=$tblfoot.$lastpage;
if($mpdf==true)
{
$pdf->writeHTML($tblfoot, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $tblfoot;

?>
