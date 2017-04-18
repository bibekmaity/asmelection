<body>
<?php
require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');
require_once './class/class.poling.php';
require_once './class/class.department.php';
require_once './class/class.Poling_training.php';
require_once './class/class.training.php';
require_once './class/class.trg_hall.php';
require_once './class/class.training_phase.php';
require_once './class/class.category.php';

//require_once './class/class.POLING.php';
$objC=new Category();

//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
//$PageOrientation="P";  //Portrait

$cwidth=array();
$cwidth[0]="5%";
$cwidth[1]="10%";
$cwidth[2]="10%";
$cwidth[3]="10%";
$cwidth[4]="10%";
$cwidth[5]="10%";
$cwidth[6]="10%";
$cwidth[7]="10%";
$cwidth[8]="10%";
$cwidth[9]="10%";
$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$mpdf=true;
//$mpdf=false;

$mrows=10;  //Rows per Page
$rheight=45; // Rows Height
$mvalue=array();

if (isset($_POST['Phaseno']))
$mvalue[0]=$_POST['Phaseno'];
else
$mvalue[0]=0;


if (isset($_POST['Groupno']))
$mvalue[1]=$_POST['Groupno'];
else
$mvalue[1]=0;

if (isset($_POST['Acq']))
$mvalue[2]=$_POST['Acq'];
else
$mvalue[2]=0;

$objTrg=new Training();
$objTrg->setPhaseno($mvalue[0]);
$objTrg->setGroupno($mvalue[1]);
$totdays=0;
if ($objTrg->EditRecord())
{ 
$place=$objTrg->getTrgplace(); 
$tDate1=$objTrg->getTrgdate1(); 
$tDate2=$objTrg->getTrgdate2();
$tDate3=$objTrg->getTrgdate3();   

$objTt=new Trg_time();
$objTt->setCode($objTrg->getTrgtime());
if ($objTt->EditRecord())
$time=$objTt->getTiming(); 
else
$time="";
$objH=new Trg_hall();
$objH->setVenue_code($objTrg->getVenue_code());
$objH->setRsl($objTrg->getHall_rsl());
if ($objH->EditRecord())
$hall=$objH->getHall_number();
else
$hall="";
}
 
if(strlen($tDate1)>2)
$totdays++;

if(strlen($tDate2)>2)
$totdays++;

if(strlen($tDate3)>2)
$totdays++;


$mdate="";
$dtcol="";

//for ($j=0;$j<3;$j++)
//{
//if (strlen($mydate[$j])>2)
//{
//$mdate=$mdate."<td width=".chr(34).$wdt."%".chr(34)." align=".chr(34)."center".chr(34).">".$mydate[$j]."</td>";   
//$dtcol=$dtcol."<td width=".chr(34).$wdt."%".chr(34)." align=".chr(34)."center".chr(34).">&nbsp;</td>";   
//}
//}


$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  align="center" width="90%" style="vertical-align:middle;">
<tr><td align="left" width="8%">&nbsp;</td>
<td align="center" width="92%" colspan="3">
<B><U>ACQUITANCE SHEET FOR ATTENDING EVM TRAINING</U></B><BR>
<b>$place<br>Hall No-$hall</b></td></tr>
<tr><td align="left" width="8%">&nbsp;</td><td align="left" width="10%">Group-$mvalue[1]</td><td align="center" width="40%"></td>
 <td align="right" width="42%">Time-$time</td></tr> 
<tr><td align="center" width=100% colspan=4>&nbsp;</td></tr>
</table>
EOD;

//retrive Perong data from text File

$mainrow=array();

$index=0;
$rcount=0;
$objP=new Poling();
$str=" Slno in(select Poling_id from Poling_Training where Phaseno=".$mvalue[0]." and Groupno=".$mvalue[1].") order by Slno";
$objP->setCondString($str);
$row=$objP->getAllRecord();


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 10);
$pdf->setPrintFooter(false);
$tblfdata="";

$tot=count($row);
$totrec=$tot;

$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  align="center" width="100%" style="vertical-align:middle;">
<tr>
<td align="center"  width="6%">&nbsp;</td>
<td align="left"  width="94%">
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  width="100%" align="center" style="vertical-align:middle;">
<tr>
<td align="center" width="7%">SlNo</td>
<td align="center" width="8%">Poling ID</td>
<td align="center" width="35%">Name & Designation of <br> Officer</td>
<td align="center" width="10%">Duty</td>
<td align="center" width="10%">Contact No</td>
<td align="center" width="10%">Amount(In Rs)<br>for $totdays Days</td>
<td align="center" width="20%">Signature</td>
</tr>
EOD;
$tblbottom=<<<EOD
</table>
</td></tr></table>
EOD;
$ddosign=<<<EOD
<p align="center">
<b>Signature of DDO</b>
</p>
EOD;
$rowcount=0;
$colvalue=array();

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

//$row=$mainrow;
$gross=0;
for($ii=0;$ii<count($row);$ii++)
{
    
$slno++;
$rowcount++;
$colvalue[0]=$ii+1;
$colvalue[1]="<b>".$row[$ii]['Slno']."</b>";
$colvalue[2]="<b>".$row[$ii]['Name']."</b>, ".$row[$ii]['Desig']."<br>".$row[$ii]['Department'];
$objC->setCode($row[$ii]['Pollcategory']);

if ($objC->EditRecord())
{
$colvalue[3]=$objC->getName();
$amt=$objC->getTrgamount()*$totdays; //Retrive Training Amount
$gross=$gross+$amt;
}
else
$colvalue[3]="";
$colvalue[4]=$row[$ii]['Phone'];

$tbldata=<<<EOD
<tr>
<td align="center" width="7%">$slno</td>
<td align="center" height="$rheight" width="8%">$colvalue[1]</td>
<td align="left" height="$rheight" width="35%">$colvalue[2]</td>
<td align="center" height="$rheight" width="10%">$colvalue[3]</td>
<td align="center" height="$rheight" width="10%">$colvalue[4]</td>
<td align="center" height="$rheight" width="10%">$amt</td>
<td align="center" height="$rheight" width="20%">&nbsp;</td>
</tr>
EOD;
$tblfdata=$tblfdata.$tbldata;
if ($rowcount>=$pgroup[$i])
{
$i++;
$pagecount++;

$tblfdata=$title.$tblhead.$tblfdata.$tblbottom;

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

} //for loop
$cspan=1;
$tblfoot=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  align="center" width="100%" style="vertical-align:middle;">
<tr>
<td align="center"  width="6%">&nbsp;</td>
<td align="left"  width="94%">
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  width="100%" align="center" style="vertical-align:middle;">
<tr>
<td colspan="5" width="70%" align="right">
Total</td><td align="center" width="10%">$gross</td><td width="20%">&nbsp;</td>
</tr>
</table>
</td></tr>
</table>
EOD;


if($mpdf==true)
{
$pdf->writeHTML($tblfoot, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}
else
echo $tblfoot;

?>
