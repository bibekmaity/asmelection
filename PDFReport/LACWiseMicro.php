<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.microps.php';
require_once '../class/class.microgroup.php';
require_once '../class/class.psname.php';
require_once '../class/class.poling.php';
//Rows per Page
if (isset($_GET['mrows']))
$mrows=$_GET['mrows'];
else
$mrows=10;

// Rows Height
if (isset($_GET['rheight']))
$rheight=$_GET['rheight'];
else
$rheight=28;

$mpdf=true;
//$mpdf=false;


$objUtility=new Utility();
$objMg=new Microgroup();
$objPsname=new Psname();
$objPol=new Poling();

//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11

$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

//$util=new myutility();
$cwidth=array();
$cwidth[0]="10%";
$cwidth[1]="35%";
$cwidth[2]="10%";
$cwidth[3]="45%";


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 9);
$pdf->setPrintFooter(false);
$tblfdata="";


if(isset($_GET['code']))
$laccode=$_GET['code'];
else 
$laccode=0;    
    
$objLac=new Lac();
$objLac->setCode($laccode);
if($objLac->EditRecord())
$lacname=$laccode." ".$objLac->getName ();
else
$lacname="";


$cond=" Lac=".$laccode;

$totrec=$objMg->rowCount($cond);

$objUtility=new Utility();
$cspan=4;
$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  height="$rheight"  align="center">
LIST OF MICRO OBSERVER
</td>
</tr>
</table>
EOD;
$tblhead=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  align="center">
<br>NAME OF LAC $lacname
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">SlNo</td>
<td align="center" width="$cwidth[1]">PS Nos and Name</td>
<td align="center" width="$cwidth[2]">Micro ID</td>
<td align="center" width="$cwidth[3]">Name of Micro Observer</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">1</td>
<td align="center" width="$cwidth[1]"><I>2</I></td>
<td align="center" width="$cwidth[2]"><I>3</I></td>
<td align="center" width="$cwidth[3]"><I>4</I></td>

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

$cond=" Lac=".$laccode." order by Reserve,Micropsno";
$objMg->setCondString($cond);
$row=$objMg->getAllRecord();
for($ii=0;$ii<count($row);$ii++)
{
$slno++;
$rowcount++;

$grp=$row[$ii]['Micropsno'];
$myrow=$objPsname->getMicroPsList($grp);    
$colvalue[1]="";
if($grp>0)
{
for($mm=0;$mm<count($myrow);$mm++)
{
$colvalue[1]=$colvalue[1].$myrow[$mm]['Part_no']."  ".$myrow[$mm]['Psname']."<br>";  
} //for loop
} //$grp>0
else
{    
if($objLac->MicrogroupStatus($laccode)>4)
$colvalue[1]="Reserve";
else
$colvalue[1]="Group Code-".$row[$ii]['Grpno'] ;  
}

$colvalue[2]=$row[$ii]['Micro_id'];
$colvalue[3]="<B>";
$objPol->setSlno($row[$ii]['Micro_id']);
if($objPol->EditRecord())
{
$colvalue[3]=$colvalue[3].$objPol->getName ()."</B>,".$objPol->getDesig ()."<br>";  
$colvalue[3]=$colvalue[3].$objPol->getDepartment()."<br>Phone-".$objPol->getPhone();  
}



$tbldata=<<<EOD
<tr>
<td align="center" width="$cwidth[0]">$slno</td>
<td align="left" height="$rheight" width="$cwidth[1]">$colvalue[1]</td>
<td align="center" height="$rheight" width="$cwidth[2]">$colvalue[2]</td>
<td align="left" height="$rheight" width="$cwidth[3]">$colvalue[3]</td>
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
$tblfdata=$tblfdata.$ddosign;
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

}//for loop
if($mpdf==true)
{
ob_end_clean();
$pdf->Output('Temp.pdf', 'I');
}

?>
