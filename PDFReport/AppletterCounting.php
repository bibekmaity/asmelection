<body>
<?php
session_start();
date_default_timezone_set("Asia/kolkata");

require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/class.poling.php';
require_once '../class/class.department.php';
require_once '../class/class.Poling_training.php';
require_once '../class/class.training.php';
require_once '../class/class.trg_hall.php';
require_once '../class/class.training_phase.php';
require_once '../class/class.category.php';
require_once '../class/class.Party_calldate.php';
require_once '../class/class.Countinggroup.php';


  
//HARDCODED DATA
$countingdate="06/04/2014";  //Modify Counting date Here
$station="Govt Gurdon HSS, Nalbari";
$starttime="7 am";
$mplace="Nalbari";
$mdate="12/8/2013";
//END HARDCODED


//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

//$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=1;
$rheight=48;


$cwidth=array();
$cwidth[0]="15%";
$cwidth[1]="37%";
$cwidth[2]="38%";

$mpdf=true;
//$mpdf=false;


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);

$tblfdata="";



$cspan=4;

$dt=date('d-M-Y h:i A');

//retrive Perong data from text File
if (isset($_POST['totdep']))
$tot=$_POST['totdep'];  
else
$tot=0;


$phase=5;  //2 is for Group Training COUNTING

$trow=array();
$mainrow=array();
$objTrg=new Training();
$objP=new Poling();
$objPg=new Countinggroup();
$index=0;

$objLac=new Lac();
$xrow=$objLac->getAllRecord();
$RoList=array();
$RoSign=array();

for($iii=0;$iii<count($xrow);$iii++)
{
$RoList[$xrow[$iii]['Code']] = $xrow[$iii]['Ro_detail'] ; 
$RoSign[$xrow[$iii]['Code']] = $xrow[$iii]['Ro_sign'] ; 
}


for($ind=1;$ind<=$tot;$ind++)
{
$Dep="Dep".$ind;

if (isset($_POST[$Dep]))
{
$page=0;    
$dcode=$_POST[$Dep];
//echo $dcode."<br>";
$cond="Depcode=".$dcode." and Countcategory in(1,2,3) and Countgrpno>0";
$prow=$objP->getCountingList($cond);   
for($j=0;$j<count($prow);$j++)    
{

$page++;    
$Slno=$prow[$j]['Slno'];
//$catg=$prow[$j]['Selected'];
$grp=$prow[$j]['Countgrpno'];
$catg=1;
$objPg->setGrpno($grp);
if ($objPg->EditRecord())
{
$pr=$objPg->getSr();
$p1=$objPg->getAst1();

//if ($objPg->getReserve()=="N")
$rcode=$objPg->getGrpno();

$laccode=$objPg->getLac();
if (isset($RoList[$laccode]))
$mainrow[$index]['RO']=$RoList[$laccode];

if (isset($RoSign[$laccode]))
$mainrow[$index]['ROSign']=$RoSign[$laccode];


if ($objP->isSelected4Trainee($Slno, 5))
$trgrp=1;
//$trgrp=$objPg->getTrggroup(); 
else
$trgrp=0;   

//echo "Tgrp=".$trgrp;
}
else
header('Location:Selectdep4app.php');


$mainrow[$index]['Page']=$page;
$mainrow[$index]['Slno']=$Slno;
$mainrow[$index]['Grp']=$grp;
$mainrow[$index]['Catg']=$catg;
$mainrow[$index]['Code']=$rcode; 

$mainrow[$index]['PR']=$objP->PolingDetail4APP($pr,$Slno);
$mainrow[$index]['P1']=$objP->PolingDetail4APP($p1,$Slno);
$mainrow[$index]['Department']=$prow[$j]['Department'];
if ($trgrp>0)
{
$trow=$objTrg->getTrainingDetail($Slno, $phase);
$mainrow[$index]['Place']=$trow['Trgplace'];
$mainrow[$index]['Hall']=$trow['Hallno'];
$mainrow[$index]['Time']=$trow['Trgtime']; 
$mainrow[$index]['tDate']=$trow['Trgdate']; 
$mainrow[$index]['tGrp']=$trow['Groupno']; 
}
else
$mainrow[$index]['tGrp']=0;    
$index++;
}//if selected for Group
}//$j++
}//for loop


//For Individau APP by ID
if( isset($_GET['id']))
{ 
if(is_numeric($_GET['id']))    
$Slno=$_GET['id'];
else
$Slno=0;
$objP->setSlno($Slno);

if($objP->EditRecord() && $objP->getCountgrpno()>0)
{
$catg=$objP->getCountselected();
$grp=$objP->getCountgrpno();

$objPg->setGrpno($grp);
if ($objPg->EditRecord())
{
$pr=$objPg->getSr();
$p1=$objPg->getAst1();

$rcode=$objPg->getGrpno();

$laccode=$objPg->getLac();
if (isset($RoList[$laccode]))
$mainrow[$index]['RO']=$RoList[$laccode];

if (isset($RoSign[$laccode]))
$mainrow[$index]['ROSign']=$RoSign[$laccode];



if ($objP->isSelected4Trainee($Slno, 5))
$trgrp= 1;
else
$trgrp=0;   
}
else
header('Location:Selectdep4app.php');

$mainrow[0]['Page']=1;
$mainrow[0]['Slno']=$Slno;
$mainrow[0]['Grp']=$grp;
$mainrow[0]['Calldate']=$calldate;
$mainrow[0]['Catg']=$catg;
$mainrow[0]['Code']=$rcode; 

$mainrow[0]['PR']=$objP->PolingDetail4APP($pr,$Slno);
$mainrow[0]['P1']=$objP->PolingDetail4APP($p1,$Slno);
$mainrow[0]['Department']=$objP->getDepartment();
if ($trgrp>0)
{
$trow=$objTrg->getTrainingDetail($Slno, $phase);
$mainrow[0]['Place']=$trow['Trgplace'];
$mainrow[0]['Hall']=$trow['Hallno'];
$mainrow[0]['Time']=$trow['Trgtime']; 
$mainrow[0]['tDate']=$trow['Trgdate']; 
$mainrow[0]['tGrp']=$trow['Groupno']; 
}
else
$mainrow[0]['tGrp']=0;    
}//$objP->EditRecord()
else
header('Location:Selectdep4app.php');
} //isset($_GET[id]


//end Individual


$tblfdata="";

$tblhead=<<<EOD
<table cellpadding="3" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  align="center">
<br>TABLE
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">
 Code No
</td>
<td align="center" width="$cwidth[1]">
 Name of the Counting Supervisor</td>
<td align="center" width="$cwidth[2]">
Name of the Counting Assistant
</td>
</tr>
EOD;

$tblbottom=<<<EOD
</table>
EOD;





$rowcount=0;
$colvalue=array();
//Initialise Total Variable

$tick="";

//Seting Page group

$pagecount=0;
    
$i=1;

$rowmain=array();
$rowmain=$mainrow;
   


$colvalue=array();
//start Actual Loop
for($ind=0;$ind<count($mainrow);$ind++)
{
$colvalue[0]=$mainrow[$ind]['Code'];
$colvalue[1]=$mainrow[$ind]['PR'];

$colvalue[2]=$mainrow[$ind]['P1'];
$roname=$mainrow[$ind]['RO'];
$rosign=$mainrow[$ind]['ROSign'];
$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;" width="100%">
<tr>
<td colspan=$cspan  align="center" width="100%">
    ANNEXURE-XLI<br>
    (CHAPTER XIV, PARA 8.4)<br>
APPOINTMENT OF COUNTING SUPERVISOR/ASSISTANTS
</td>
</tr>
<td colspan="$cspan"   align="left" width="100%">
General Bye Election  2014 to the House of the people...
</td>
</tr>
<td colspan="$cspan"   align="left" width="100%">
Legislative Assembly of  
</td>
</tr>
<tr>
<td colspan="$cspan"   align="left" width="100%">
<div align="justify" style="line-height:2">
<br>
I <b>$roname</b> appoint the persons whose names are
specified below to act as Counting Supervisor/Assistants and to attend
at $starttime on $countingdate at $station for the
purpose of assisting me in the Counting of votes at the 
said election.
</div>
</td>
</tr>
</table>
EOD;

$ddosign=<<<EOD
<p align="center">&nbsp;</p>
<p align="center"><br>
<b>$rosign</b>
</p>
EOD;

$tbldata=<<<EOD
<tr>
<td align="center"><br><br><br><b>$colvalue[0]</b></td>
<td align="left">$colvalue[1]</td>
<td align="left">$colvalue[2]</td>
</tr>
</table>
EOD;


$tblfoot=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;" width="100%">
<tr>
<td  align="left" width="60%">
<br><br>
Place: $mplace
<br>
Date: $mdate
</td>
<td  align="right" width="40%">
<br>
$ddosign
</td>
</tr>
<tr>
<td  align="left" width="60%">
<br>
</td></tr>
</table>
EOD;

$trgrp=$mainrow[$ind]['tGrp'];
if ($trgrp>0)
{
$Date=$mainrow[$ind]['tDate'];
$Time=$mainrow[$ind]['Time'];
$Place=$mainrow[$ind]['Place'];
$Hall=$mainrow[$ind]['Hall'];

$training=<<<EOD
<p align="center">&nbsp;</p>
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  align="center" style="vertical-align:middle;" width="100%">
<tr>
<td align="left" width="100%" colspan="2"><u><b>Training for Supervisor and Assistant</b></u></td>
</tr>
<tr>
<td align="left" colspan="2">
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  align="center" style="vertical-align:middle;" width="100%">
<tr>
<td align="center" width="20%">Date</td>
<td align="center" width="20%">Time</td>
<td align="center" width="35%">Place</td>
<td align="center" width="25%">Hall/Room</td>
</tr>
<tr>
<td align="center"  width="20%"><b>$Date</b></td>
<td align="center"  width="20%"><b>$Time</b></td>
<td align="center" width="35%"><b>$Place</b></td>
<td align="center" width="25%"><b>$Hall</b></td>
</tr>
</table>
</td>
</tr>
<tr>
<td  width="60%">
&nbsp;
</td>
<td  width="40%"> 
<br><br>
$ddosign
</td>
</tr>
</table>
EOD;
}
else
$training="<br>";

$department=$mainrow[$ind]['Department'];
$Slno=$mainrow[$ind]['Slno'];
$page=$mainrow[$ind]['Page'];
$dept=<<<EOD
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<table border=0 width="100%">
<tr><td width="100%" colspan=2 align="center">
<hr>
</td></tr>
<tr><td width="85%" align="left">
<b>$department</b>(Poling Id-$Slno)<br>Computer generated document dated $dt
</td>
<td width="15%" align="right">Page-$page</td>
</tr>
</table>
EOD;


if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTML($title, true, false, false, false, '');
$pdf->SetFont('helvetica', '', 8);
$pdf->writeHTML($tblhead.$tbldata, true, false, false, false, '');

//$pdf->writeHTML($tbldata, true, false, false, false, '');

$pdf->writeHTML($tblfoot, true, false, false, false, '');

$pdf->writeHTML($training, true, false, false, false, '');

$pdf->writeHTML($dept, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 9);
//$pdf->SetFont('helvetica', '', 9);
}
else
echo $title.$tblhead.$tbldata.$tblfoot.$training.$dept;
   
}

if ($mpdf==true)
{
ob_end_clean();
$pdf->Output('report.pdf', 'I');
}

?>
