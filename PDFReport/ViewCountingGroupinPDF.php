<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.Countinggroup.php';
require_once '../class/class.poling.php';
require_once '../class/class.lac.php';
require_once '../class/class.hpc.php';
require_once '../class/class.party_calldate.php';
$objPt=new Party_calldate();

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


$objCountinggroup=new Countinggroup();
//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=18;  //Rows per Page
$rheight=54; // Rows Height

if(isset($_GET['code']))
$laccode=$_GET['code'];
else 
$laccode=0;

if(isset($_POST['mpdf']))
$mpdf=true;
else
$mpdf=false;

if(!is_numeric($laccode))
$laccode=0;

if($laccode==0)
header('location:StartCountGroup.php?tag=0');    
    
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
echo $laccode;
    
    
$cwidth=array();
$cwidth[0]="8%";
$cwidth[1]="10%";
$cwidth[2]="52%";
$cwidth[3]="18%";
$cwidth[4]="12%";
$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 9);
$pdf->setPrintFooter(false);
$tblfdata="";
$objCountinggroup=new Countinggroup();
$cond="CountGrpno in (Select grpno from Countinggroup where lac=".$laccode.") order by Countgrpno,countcategory";
$totrec=$objPoling->rowCount($cond);
$objUtility=new Utility();
$cspan=9;
$title=<<<EOD
&nbsp;
EOD;
$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan="5"  align="center">
Counting Supervisor/Assistant/Static Observer for <b>$laccode-$lacname</b>&nbsp;LAC
under HPC-<b>$hpccode-$hpcname</b>
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">Sl No</td>
<td align="center" width="$cwidth[1]">Group Code</td>
<td align="center" width="$cwidth[2]">Name of Officers</td>
<td align="center" width="$cwidth[3]">Category</td>
<td align="center" width="$cwidth[4]">Phone</td>
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
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;
//Presiding Officer
$cat=$row[$ii]['Countcategory'];
$colvalue[0]=$row[$ii]['Countgrpno'];
$colvalue[1]="<b>".$row[$ii]['Name']."</b>,".$row[$ii]['Desig']."<br>".$row[$ii]['Department'];
$colvalue[1]=$colvalue[1]."<br>Id-".$row[$ii]['Slno'];
$colvalue[2]=$objUtility->CountCategory[$cat];
$colvalue[3]=$row[$ii]['Phone'];
$tbldata=<<<EOD
<tr>
<td align="center" width="$cwidth[0]">$slno</td>
<td align="center" height="$rheight" width="$cwidth[1]"><b>$colvalue[0]</b></td>
<td align="left" height="$rheight" width="$cwidth[2]">$colvalue[1]</td>
<td align="center" height="$rheight" width="$cwidth[3]">$colvalue[2]</td>
<td align="center" height="$rheight" width="$cwidth[4]">$colvalue[3]</td>

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
}
$tblfoot="<br><br>";
$tblfoot=$tblfoot.$ddosign.$lastpage;
if($mpdf==true)
{
$pdf->writeHTML($tblfoot, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $tblfoot;

?>
