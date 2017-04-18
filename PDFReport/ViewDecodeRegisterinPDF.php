<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.party_calldate.php';
require_once '../class/class.Training_phase.php';
require_once '../class/class.Sentence.php';
//Rows per Page



$mrows=15;

$fontsize=10;

if(isset($_POST['mpdf']))
$mpdf=true;
else
{
if(isset($_GET['mpdf']))
$mpdf=true;
else
$mpdf=false;
}


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
$objSen=new Sentence();
$deo=$objSen->SentenceCase($sign)."<br>".$objSen->SentenceCase($district);



$rheight=50;



$objUtility=new Utility();
$objPsname=new Psname();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

//$util=new myutility();
$cwidth=array();
$cwidth[0]="10%";
$cwidth[1]="10%";
$cwidth[2]="9%";
$cwidth[3]="23%";
$cwidth[4]="9%";
$cwidth[5]="9%";
$cwidth[6]="30%";


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->SetFont('helvetica', '', $fontsize);
$pdf->setPrintFooter(false);
$tblfdata="";

if(isset($_POST['Code']))
$laccode=$_POST['Code'];
else
{
if(isset($_GET['Code']))    
$laccode=$_GET['Code'];
else
$laccode=0;    
}    

//echo $laccode;

if(isset($_POST['rtag']))
$rtag=$_POST['rtag'];
else
{
if(isset($_GET['rtag']))
$rtag=$_GET['rtag'];    
else
$rtag=-1;     
}
 
//echo $rtag;


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


if($a1>0 && $a2>0 && $a1<=$a2)
$cond="lac=".$laccode." and Rcode>='".$a1."' and Rcode<='".$a2."' and REPORTING_TAG=".$rtag;
else
$cond="lac=".$laccode." and REPORTING_TAG=".$rtag;


$totrec=$objPsname->rowCount($cond);

$cond=$cond." order by Rcode";

$objUtility=new Utility();
$cspan=7;

$title=<<<EOD
<P align="center">
OFFICE OF THE $sign:::$district<br>
</P>    
EOD;

$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=6  align="center" width="70%">
DECODING REGISTER FOR LAC $laccode- $lacname
</td>
<td colspan=6  align="center" width="30%">
$date1
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">SlNo</td>
<td align="center" width="$cwidth[1]">Group Code</td>
<td align="center" width="$cwidth[2]">PS No</td>
<td align="center" width="$cwidth[3]">Poling Station Name</td>
<td align="center" width="$cwidth[4]">Male Voter</td>
<td align="center" width="$cwidth[5]">Female Voter</td>
<td align="center" width="$cwidth[6]">Full Signature & Poling ID</td>
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
$tot5=0;
$tot6=0;
$tot7=0;
$tot8=0;
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
$objPsname->setCondString($cond);
$row=$objPsname->getAllRecord();
//echo $objPsname->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;
$colvalue[0]=$row[$ii]['Rcode'];
$colvalue[1]=$row[$ii]['Part_no'];
$colvalue[2]=$row[$ii]['Psname']."<br>".$row[$ii]['Address'];
$colvalue[3]=$row[$ii]['Male'];
$colvalue[4]=$row[$ii]['Female'];

$tbldata=<<<EOD
<tr>
<td align="center" width="$cwidth[0]">$slno</td>
<td align="center" height="$rheight" width="$cwidth[1]">$colvalue[0]</td>
<td align="center" height="$rheight" width="$cwidth[2]">$colvalue[1]</td>
<td align="left" height="$rheight" width="$cwidth[3]">$colvalue[2]</td>
<td align="center" height="$rheight" width="$cwidth[4]">$colvalue[3]</td>
<td align="center" height="$rheight" width="$cwidth[5]">$colvalue[4]</td>
<td align="center" height="$rheight" width="$cwidth[6]">&nbsp;</td>
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

if($mpdf==true)
$pdf->writeHTML($ddosign, true, false, false, false, '');
else
echo $ddosign;    
    
if($mpdf==true)
{
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}


?>
